<?php

namespace App\Http\Controllers\CP\SystemConfig;

use App\Http\Controllers\Controller;
use App\Models\BeneficiresCoulumns;
use App\Models\ConstName;
use App\Models\ConstParnet;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class SystemConstController extends Controller
{

    public function index() {
        return view("CP.SystemConfig.const", [
            'parnets' => ConstParnet::all()
        ]);
    }

    public function list(Request $request) {
        $constParnets = ConstName::query()
            ->when($request->parnet_id, function ($query) use($request) {
            $query->where('parnet_id', $request->parnet_id);
        })
        ->when($request->name, function($query) use ($request) {
            $query->where("name", 'LIKE', '%' .$request->name . '%');
        });
//        dd($constParnets->get());
        return DataTables::of($constParnets)
            ->addColumn('actions', function ($const_name) {
                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="'.route('const.update_from',['constName'=>$const_name->id]).'">تعديل</a>
                                                <a class="dropdown-item" href="#" onclick="delete_const(' . $const_name->id . ', \'' . route('const.delete') . '\')" >حذف</a>
                                            </div>
                                        </div>';

                return $element;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function add() {
        return view("CP.SystemConfig.const_add", [
            'parnets' => ConstParnet::all()
        ]);
    }

    public function store(Request $request) {
        ConstName::query()->create($request->all());
        return back()->with(['success' => 'تمت عمليه الإضافة بنجاح']);
    }

    public function delete(Request $request)
    {

        ConstName::query()->find(request('id'))->delete();
        return response()->json([
            'message' => 'تمت عمليه الحذف بنجاخ بنجاح',
            'success' => true
        ]);
    }


    public function update_from(Request $request,ConstName $constName)
    {
        $data['const']=$constName;
        $data['parnets'] = ConstParnet::all();
        return view('CP.SystemConfig.const_update', $data);
    }
    public function update(Request $request)
    {
        ConstName::query()->where('id', $request->id)->first()->update($request->all());
        return back()->with('success', 'تمت عمليه التعديل بنجاح');

    }
}
