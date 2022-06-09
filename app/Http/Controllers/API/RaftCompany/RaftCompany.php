<?php

namespace App\Http\Controllers\API\RaftCompany;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Controllers\Controller;


use App\Http\Requests\MaintainanceUploadFile;
use App\Http\Requests\SaveNote;
use App\Http\Resources\RaftCompanyLocationResource;
use App\Http\Resources\SessionResource;
use App\Models\RaftCompanyBox;
use App\Models\RaftCompanyLocation;
use App\Models\Session;
use App\Models\User;
use App\Notifications\TasleemMaintenanceNotification;
use Carbon\Carbon;
use ConvertApi\ConvertApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;


class RaftCompany extends Controller
{

    public function sessions(Request $request)
    {

        $sessions = Session::query()->published()->where('raft_company_location_id',auth('users')->user()->raft_company_type)->with('RaftCompanyLocation.user', 'RaftCompanyBox');

        $sessions->when($request->from_date && $request->to_date, function ($q) use ($request) {
            $q->whereBetween('start_at', [$request->from_date, $request->to_date]);
        });
        $sessions = $sessions->paginate(request('per_page') ?? 10);
        return api(true, 200, 'تمت العمليه بنجاح')
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

    public function upload_file(MaintainanceUploadFile $request){

        $Session = Session::query()->where('id', $request->session_id)->first();

        $type=$request->type;

        if ($request->file('file')) {
            $path = Storage::disk('public')->put("service_provider", $request->file('file'));
            $file_name = request('file')->getClientOriginalName();

            $update = [];
            $update[$type] = $path;
            $update[$type . '_name'] = $file_name;

            RaftCompanyBox::where('id', $Session->raft_company_box_id)->update($update);
        }
        return api(true, 200, 'تمت العمليه بنجاح')
            ->get();
    }
    public function save_note(SaveNote $request){

        $Session = Session::query()->where('id', $request->session_id)->first();

        if (!($Session->RaftCompanyBox->file_first_name && $Session->RaftCompanyBox->file_second_name && $Session->RaftCompanyBox->file_third_name)) {

            return api(false, 400, 'الرجاء إرفاق جميع الملفات')
                ->get();
        }

        RaftCompanyBox::where('id', $Session->raft_company_box_id)->update(['tasleem_notes' => $request->note]);

        return api(true, 200, 'تمت العمليه بنجاح')
            ->get();
    }
    public function docx_file(Request $request)
    {

        $file_type = $this->fileType($request->file_type);
        $session=Session::query()->find($request->session_id);
        if(!$session){
            return api(false, 404, 'لم يتم العثور على الموعد')
                ->get();
        }
        $file_name = uniqid(auth('users')->user()->id . '_') . '.docx';

        $templateProcessor = new TemplateProcessor(Storage::disk('public')->path($file_type));

        $templateProcessor->setValues([
            'box' => $session->RaftCompanyBox->box,
            'cmp' => $session->RaftCompanyBox->camp,
            'date' => Hijri::Date('Y/m/d'),
            'time' => now()->format('H:i')
        ]);
        $templateProcessor->saveAs(Storage::disk('public')->path('service_provider_generator/' . $file_name));

        ConvertApi::setApiSecret('uVAzHfhZAhfyQ1mZ');
        $result = ConvertApi::convert('pdf', [
            'File' => Storage::disk('public')->path('service_provider_generator/' . $file_name)
        ], 'docx'
        );

        $result->saveFiles(Storage::disk('public')->path('service_provider_generator/' . Str::replace('.docx','.pdf',$file_name)));

        return api(true, 200, 'تمت العمليه بنجاح')
            ->add('path',Storage::disk('public')->path('service_provider_generator/' . Str::replace('.docx','.pdf',$file_name)))
            ->get();
    }

    public function fileType($type)
    {

        if (!in_array($type, [1, 2, 3])) {
            abort(404);
        }
        return [
            '1' => 'محضر قراءة عداد الكهرباء الخاص بالمخيم.docx',
            '2' => 'كشف بالملاحظات والتلفيات والمفقودات عند تسليم المخيمات للجهات المستفيدة لموسم حج 1443 هـ.docx',
            '3' => 'محضر تسليم المخيمات.docx'
        ][$type];
    }

    public function seen_maintain_file(Request $request)
    {
        $session=Session::query()->find($request->session_id);
        if(!$session){
            return api(false, 404, 'لم يتم العثور على الموعد')
                ->get();
        }
        $session->RaftCompanyBox->update([
            'seen_notes'=>1
        ]);
        return api(true, 200, 'تمت العمليه بنجاح')
            ->get();
    }
}
