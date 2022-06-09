<?php

namespace App\Http\Controllers\API\TaslemMaintenance;

use App\Http\Controllers\Controller;


use App\Http\Resources\RaftCompanyLocationResource;
use App\Http\Resources\SessionResource;
use App\Models\RaftCompanyBox;
use App\Models\RaftCompanyLocation;
use App\Models\Session;
use App\Models\User;
use App\Notifications\TasleemMaintenanceNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TaslemMaintainance extends Controller
{

    public function sessions(Request $request, $list_type = null)
    {
        $sessions = Session::query()->published()->where('support_id', auth('users')->user()->id)->with('RaftCompanyLocation.user', 'RaftCompanyBox');

        if ($list_type == 'today') {

            $sessions = $sessions->whereDate('start_at', '=', now()->format('Y-m-d'));
        }
//
//        if ($request->raft_company_location_id) {
//            $sessions = $sessions->where('raft_company_location_id', $request->raft_company_location_id);
//        }

        $sessions->when($request->from_date && $request->to_date, function ($q) use ($request) {
            $q->whereBetween('start_at', [$request->from_date, $request->to_date]);
        });
        $sessions = $sessions->paginate(request('per_page') ?? 10);
        return api(true, 200, __('api.success'))
            ->add('sessions', SessionResource::collection($sessions), $sessions)
            ->get();

    }

    public function company_box(Request $request)
    {
        $raft_company = RaftCompanyLocation::query()->get();

        return api(true, 200, 'تمت العمليه بنجاح')
            ->add('sessions', RaftCompanyLocationResource::collection($raft_company))
            ->get();
    }

    public function save_session(Request $request)
    {

        $getRaftCompanyBox = RaftCompanyBox::where([['camp', $request->camp_number], ['box', $request->box_number]])->first();
        if (!$getRaftCompanyBox) {
            return api(false, 404, 'لم يتم العثور على رقم المربع والمخيم في قاعدة البيانات')
                ->get();
        }

        $Session = Session::where([['support_id', auth('users')->user()->id], ['raft_company_box_id', $getRaftCompanyBox->id]])->notPublished()->first();

        if (!$Session) {
            $Session = new Session;
            $Session->raft_company_box_id = $getRaftCompanyBox->id;
            $Session->raft_company_location_id = $getRaftCompanyBox->raft_company_location_id;
            $Session->support_id = auth('users')->user()->id;
        }
        $Session->start_at = Carbon::parse($request->start_at)->format("Y-m-d h:i");
        $Session->save();
        return api(true, 200, 'تمت العمليه بنجاح')
            ->get();
    }
    public function publish_sessions(Request $request)
    {
        try {
            $Sessions = Session::where('support_id',  auth('users')->user()->id)->notPublished()->with('RaftCompanyLocation', 'RaftCompanyBox')->get();

            $raftUsers = [];

            foreach ($Sessions as $Session) {

                if (!isset($raftUsers[$Session->raft_company_location_id])) {
                    $raftUsers[$Session->raft_company_location_id] = 0;
                }
                $raftUsers[$Session->raft_company_location_id]++;


            };

            foreach ($Sessions as $session) {

                $user = User::where('type', 'raft_company')->where('raft_company_type', $session->raft_company_location_id)->first();

                if ($user && $user->phone) {

                    $box = RaftCompanyBox::query()->where('id', $session->raft_company_box_id)->first();

                    sms($user->phone, __('message.appointment', [
                        'camp' => optional($box)->camp,
                        'box' => optional($box)->box,
                        'company_name' => $user->company_name
                    ]));
                }
            }

            $Users = User::where('type', 'raft_company')->whereIn('raft_company_type', array_keys($raftUsers))->get();

            foreach ($Users as $User) {
                $User->notify(new TasleemMaintenanceNotification('لديك مواعيد مقابلة جديدة يرجى منك متابعتها',  auth('users')->user()->id));
            }

            Session::where('support_id',  auth('users')->user()->id)->notPublished()->update(['is_published' => '1']);

            return api(true, 200, 'تمت العمليه بنجاح')
                ->get();
        } catch (\Exception | \Error $exception) {
            return api(false, 404, 'خطا تقني الرجاء المحاولة لاحقا')
                ->get();

        }
    }

}
