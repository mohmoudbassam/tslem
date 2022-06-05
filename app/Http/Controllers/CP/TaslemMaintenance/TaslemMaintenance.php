<?php

namespace App\Http\Controllers\CP\TaslemMaintenance;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderSharer;
use App\Models\OrderSharerReject;
use App\Models\ServiceProviderFiles;
use App\Models\Session;
use App\Models\User;
use App\Notifications\TasleemMaintenanceNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\RaftCompanyBox;

class TaslemMaintenance extends Controller
{
    public function index()
    {
        if(request()->route()->getName() == 'taslem_maintenance.sessions.toDaySessions'){
            $data['isToday'] = true;
        }else {
            $data['isToday'] = false;
        }
        return view('CP.taslem_maintenance_layout.index',$data);
    }

    public function list($list_type,Request $request)
    {

        $sessions = Session::query()->published()->where('support_id', auth()->user()->id)->with('RaftCompanyLocation','RaftCompanyBox');

        if($list_type == 'today'){
            $sessions = $sessions->whereDate('start_at', '=', now()->format('Y-m-d'));
        }

        if($request->raft_company_location_id){
            $sessions = $sessions->where('raft_company_location_id', $request->raft_company_location_id);
        }

        $sessions->when($request->from_date && $request->to_date, function ($q) use ($request) {
            $q->whereBetween('start_at', [$request->from_date, $request->to_date]);
        });


        return DataTables::of($sessions)
            ->addColumn('actions', function ($session) {
                return '<div class="d-flex justify-content-end"><div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="' . route('taslem_maintenance.add_files', ['session_id' => $session->id]) . '">إضافة الملفات</a>
                                            </div>
                                        </div></div>';
            })->rawColumns(['actions'])
            ->make();
    }

    public function sessions_list(Request $request)
    {

        $Sessions = Session::where('support_id',auth()->user()->id)->notPublished()->with('RaftCompanyLocation','RaftCompanyBox');


        return DataTables::of($Sessions)
        ->addColumn('actions', function ($session) {
            $element = '<div class="justify-content-end d-flex"><button type="button" class="btn btn-info btn-sm" onclick="delete_session(' . $session->id . ' )" href="javascript:;"><i class="fa fa-trash mx-1"></i>حذف</button></div>';
            return $element;

        })->rawColumns(['actions'])
            ->make();
    }

    public function add_session_form(Request $request)
    {
        $data['boxes'] = \App\Models\RaftCompanyBox::query()->select('box')->groupBy('box')->get()->toArray();
        return view('CP.taslem_maintenance_layout.add_session_form',$data);
    }

    public function publish_session(Request $request)
    {
        $Sessions = Session::where('support_id', auth()->user()->id)->notPublished()->with('RaftCompanyLocation','RaftCompanyBox')->get();
        
        $raftUsers = [];

        foreach($Sessions as $Session){
            if(!isset($raftUsers[$Session->raft_company_location_id])){
                $raftUsers[$Session->raft_company_location_id] = 0;
            }
            $raftUsers[$Session->raft_company_location_id]++;


        }

        $Users = User::where('type','raft_company')->whereIn('raft_company_type',array_keys($raftUsers))->get();

        foreach($Users as $User){
            $User->notify(new TasleemMaintenanceNotification('لديك مواعيد مقابلة جديدة يرجى منك متابعتها', auth()->user()->id));
        }

        Session::where('support_id', auth()->user()->id)->notPublished()->update(['is_published' => '1']);    

        return response()->json([
            'message' => 'تمت عمليه النشر  بنجاح',
            'success' => true
        ]);
    }

    public function save_session(Request $request)
    {


        $getRaftCompanyBox = RaftCompanyBox::where([['camp',$request->camp_number],['box',$request->box_number]])->first();
        if(!$getRaftCompanyBox){
            return response()->json([
                'message' => 'لم يتم العثور على رقم المربع والمخيم في قاعدة البيانات',
                'success' => false
            ]);
        }
        
        $Session = Session::where([['support_id',auth()->user()->id],['raft_company_box_id',$getRaftCompanyBox->id]])->notPublished()->first();
        if(!$Session){
            $Session = new Session;
            $Session->raft_company_box_id = $getRaftCompanyBox->id;
            $Session->raft_company_location_id = $getRaftCompanyBox->raft_company_location_id;
            $Session->support_id = auth()->user()->id;
        }
        $Session->start_at = Carbon::parse($request->start_at)->format("Y-m-d h:i");
        $Session->save();

        return response()->json([
            'message' => 'تمت عمليه الاضافة  بنجاح',
            'success' => true
        ]);
    }

    public function delete_session(Request $request)
    {
        
        $Session = Session::where([['support_id',auth()->user()->id],['id',$request->session_id]])->delete();

        return response()->json([
            'message' => 'تمت عمليه الاضافة  بنجاح',
            'success' => true
        ]);
    }

    public function add_files($sessionId)
    {
        $Session = Session::where('id',$sessionId)->with('RaftCompanyLocation','RaftCompanyBox')->first();
    return view('CP.taslem_maintenance_layout.add_files', [
            'session' => $Session
        ]);
    }

    public function upload_file(Request $request, $session_id, $type)
    {
        $Session = Session::query()->where('id', $session_id)->first();

        if ($request->file('file')) {
            $path = Storage::disk('public')->put("service_provider", $request->file('file'));
            $file_name = request('file')->getClientOriginalName();

            $update = [];
            $update[$type] = $path;
            $update[$type.'_name'] = $file_name;
    
            RaftCompanyBox::where('id',$Session->raft_company_box_id)->update($update);
        }

        
        return response()->json([
            'message' => 'تم الرفع بنجاح',
            'success' => true
        ]);
    }

    public function download_file($id)
    {
        $file = ContractorReportFile::query()->where('id', $id)->first();

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=$file->path",
        ];

        return (new Response(Storage::disk('public')->get($file->path), 200, $headers));

    }


    public function save_note(Request $request)
    {
        $Session = Session::query()->where('id', $request->session_id)->first();
        RaftCompanyBox::where('id',$Session->raft_company_box_id)->update(['tasleem_notes' => $request->note]);

        return redirect()->route('taslem_maintenance.index')->with(['success' => 'تمت اضافة الملفات والملاحظات بنجاح']);
    }

}