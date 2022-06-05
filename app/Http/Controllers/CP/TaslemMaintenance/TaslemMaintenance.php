<?php

namespace App\Http\Controllers\CP\TaslemMaintenance;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderSharer;
use App\Models\OrderSharerReject;
use App\Models\ServiceProviderFiles;
use App\Models\Session;
use App\Models\User;
use App\Notifications\OrderNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\OrderService;
use App\Models\OrderSpecilatiesFiles;

class TaslemMaintenance extends Controller
{
    public function index()
    {
        return view('CP.taslem_maintenance_layout.index');
    }

    public function list(Request $request)
    {

        $sessions = Session::query()->where('support_id', auth()->user()->id)->with('service_provider');

        $sessions->when($request->from_date && $request->to_date, function ($q) use ($request) {
            $q->whereBetween('start_at', [$request->from_date, $request->to_date]);
        });


        return DataTables::of($sessions)
            ->addColumn('actions', function ($sessions) {
                return '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="' . route('taslem_maintenance.add_files', ['service_provider_id' => $sessions->service_provider->id]) . '">إضافة الملفات</a>
                                            </div>
                                        </div>';
            })->rawColumns(['actions'])
            ->make();
    }

    public function users_list(Request $request)
    {

        if (is_null($request->box_number) || is_null($request->camp_number)) {
            return DataTables::of([]);
        }
        $users = User::query()->where('verified', 1)
            ->when($request->box_number, function ($q) use ($request) {

                $q->where("box_number", 'like', '%' . $request->box_number . '%');
            })
            ->when($request->camp_number, function ($q) use ($request) {
                $q->where("camp_number", 'like', '%' . $request->camp_number . '%');
            });


        return DataTables::of($users)
            ->addColumn('actions', function ($user) {
                $element = '<div class="btn-group me-1 mt-2">
                                <input type="checkbox" class="form-radio-primary user_id" name="user_id[]" id="user_id_' . $user->id . '" value="' . $user->id . '">
                            </div>';

                return $element;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function add_session_form(Request $request)
    {
        return view('CP.taslem_maintenance_layout.add_session_form');
    }

    public function save_session(Request $request)
    {

        $user_sessions=$request->except('user_id','_token','user');

        foreach($user_sessions as $user_id=>$session){
            $session = Session::query()->create([
                'user_id' => $user_id,
                'support_id' => auth()->user()->id,
                'start_at' => Carbon::parse($session)->format("Y-m-d h:i"),
            ]);
        }

        $session->service_provider->service_provider_status = 1;
        $session->service_provider->save();
        $session->service_provider->notify(new OrderNotification('يوجد لديك موعد مقابله', auth()->user()->id));
        return response()->json([
            'message' => 'تمت عمليه الاضافة  بنجاح',
            'success' => true
        ]);
    }

    public function add_files($service_provider_id)
    {
        $user = User::query()->findOrFail($service_provider_id);

        $session = Session::query()->where('user_id', $service_provider_id)->first();

        return view('CP.taslem_maintenance_layout.add_files', [
            'user' => $user,
            'session' => $session
        ]);
    }

    public function upload_file(Request $request, $service_provider_id, $type)
    {
        $file = ServiceProviderFiles::query()
            ->where('service_providers_id', $service_provider_id)
            ->where('type', $type)->first();

        if (!is_null($file)) {
            $file->delete();
        }
        if ($request->file('file')) {
            $path = Storage::disk('public')->put("service_provider", $request->file('file'));
            $file_name = request('file')->getClientOriginalName();
            ServiceProviderFiles::query()->create([
                'service_providers_id' => $service_provider_id,
                'type' => $type,
                'maintainers_id' => auth()->user()->id,
                'real_name' => $file_name,
                'path' => $path,

            ]);
        }

    }

    public function to_day_list(Request $request)
    {

        $sessions = Session::query()->whereDate('start_at', '=', now()->format('Y-m-d'))
            ->where('support_id', auth()->user()->id)
            ->with('service_provider');

        $sessions->when($request->from_date && $request->to_date, function ($q) use ($request) {
            $q->whereBetween('start_at', [$request->from_date, $request->to_date]);
        });


        return DataTables::of($sessions)
            ->addColumn('actions', function ($sessions) {
                return '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="' . route('taslem_maintenance.add_files', ['service_provider_id' => $sessions->service_provider->id]) . '">إضافة الملفات</a>
                                            </div>
                                        </div>';
            })->rawColumns(['actions'])
            ->make();
    }

    public function save_note(Request $request)
    {

        $user = User::query()->where('id', $request->service_provider_id)->first();
        $user->update([
            'service_provider_note' => $request->note,
            'service_provider_status' => 2
        ]);
        $user->notify(new OrderNotification('تمت اضافة الملفات من مكتب الصيانة', auth()->user()->id));
        return redirect()->route('taslem_maintenance.index')->with(['success' => 'تمت اضافة الملاحظات بنجاح']);

    }

    public function toDaySessions(Request $request)
    {
        return view('CP.taslem_maintenance_layout.toDaySessions');
    }

    public function getTable($uesr_ids)
    {
        $ids = explode(',', $uesr_ids,);
        $service_providers = User::query()->whereIn('id', $ids)->get();

        return response()->json([
            'success' =>true,
           'page'=> view('CP.taslem_maintenance_layout.service_providers_table_sessions',[
                'users'=>$service_providers
            ])->render()
        ]) ;
    }
}
//////////////service_provider_status => 0 havent appointment
//////////////service_provider_status => 1 have appointment
//////////////service_provider_status => 2 have a file after manitener add files to service provider
//////////////service_provider_status => 3 confirmed files
