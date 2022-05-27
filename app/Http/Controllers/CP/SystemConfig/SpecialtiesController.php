<?php

namespace App\Http\Controllers\CP\SystemConfig;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceFileType;
use App\Models\Specialties;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SpecialtiesController extends Controller
{

    public function index() {
        return view("CP.SystemConfig.specialties");
    }

    public function list(Request $request) {
        $services = Specialties::query()
//            ->when($request->parnet_id, function ($query) use($request) {
//            $query->where('parnet_id', $request->parnet_id);
//        })
            ->when($request->name, function($query) use ($request) {
                $query->where("name_ar", 'LIKE', '%' .$request->name . '%');
            });
        return DataTables::of($services)
            ->addColumn('actions', function ($service) {
                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="'.route('specialties.update_from',['specialties'=>$service->id]).'">تعديل</a>
                                                <a class="dropdown-item" href="#" onclick="delete_const(' . $service->id . ', \'' . route('specialties.delete') . '\')" >حذف</a>
                                                <a class="dropdown-item" href="' . route("service.index", [ 'specialties_id' => $service->id ]) . '">عرض الخدمات</a>
                                            </div>
                                        </div>';

                return $element;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function add() {
        return view("CP.SystemConfig.specialties_add", [
            'specialties' => Specialties::all(),
        ]);
    }

    public function store(Request $request) {
//        dd($request->all());
        $service = Specialties::query()->create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);

        return response()->json([
            'message' => 'تمت العملية بنجاح',
            'success' => true
        ]);
//        return back()->with(['success' => 'تمت عمليه الإضافة بنجاح']);
    }

    public function delete(Request $request)
    {
        Specialties::query()->findOrFail(request('id'))->delete();
        return response()->json([
            'message' => 'تمت عمليه الحذف  بنجاح',
            'success' => true
        ]);
    }


    public function update_from(Request $request, Specialties $specialties)
    {
        $data['specialties']=$specialties;

        return view('CP.SystemConfig.specialties_update', $data);
    }
    public function update(Request $request)
    {
        $service = Specialties::query()->where('id', $request->id)->firstOrFail();
        $service->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);

        return response()->json([
            'message' => 'تمت عمليه التعديل بنجاح',
            'success' => true
        ]);

    }
}
