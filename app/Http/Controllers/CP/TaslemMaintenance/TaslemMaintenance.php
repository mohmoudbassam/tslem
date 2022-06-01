<?php

namespace App\Http\Controllers\CP\TaslemMaintenance;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderSharer;
use App\Models\OrderSharerReject;
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

    public function list(Request $request) {

        $sessions = Session::query()->with('user');

        $sessions->when($request->from_date&&$request->to_date,function($q)use($request){
           $q->whereBetween('start_at',[$request->from_date,$request->to_date]);
        });


        return DataTables::of($sessions)
            ->make();
    }

    public function users_list(Request $request) {
        $users = User::query()
            ->when(!$request->box_number && !$request->camp_number, function ($q) {
                $q->where('id', '-1');
            })
            ->when($request->box_number, function ($q) use($request) {
                $q->where("box_number", 'like', '%'. $request->box_number.'%');
            })
            ->when($request->camp_number, function ($q) use($request) {
                $q->where("camp_number",'like%','%'. $request->box_number.'%'  );
            });



//        dd($users->get());
        return DataTables::of($users)
            ->addColumn('actions', function ($user) {
                $element = '<div class="btn-group me-1 mt-2">
                                <input type="radio" class="form-radio-primary" name="user_id" id="user_id" value="' . $user->id . '">
                            </div>';

                return $element;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function add_session_form(Request $request) {
        return view('CP.taslem_maintenance_layout.add_session_form');
    }

    public function save_session(Request $request) {
        $has_session=Session::query()->where('user_id',$request->user_id)->first();
        if($has_session){
            return response()->json([
                'message' => 'هذا المستخدم لديه موعد مسبق',
                'success' => false
            ]);
        }
        Session::query()->create([
            'user_id' => $request->user_id,
            'support_id' => auth()->user()->id,
            'start_at' => Carbon::parse($request->start_at)->format("Y-m-d h:i"),
        ]);

        return response()->json([
            'message' => 'تمت عمليه الاضافة  بنجاح',
            'success' => true
        ]);
    }
}
