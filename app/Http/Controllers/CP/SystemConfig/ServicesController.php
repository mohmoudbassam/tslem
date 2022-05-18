<?php

namespace App\Http\Controllers\CP\SystemConfig;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceFileType;
use App\Models\Specialties;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServicesController extends Controller
{

    public function index() {
        return view("CP.SystemConfig.services");
    }

    public function list(Request $request) {
        $services = Service::query()
//            ->when($request->parnet_id, function ($query) use($request) {
//            $query->where('parnet_id', $request->parnet_id);
//        })
        ->when($request->name, function($query) use ($request) {
            $query->where("name", 'LIKE', '%' .$request->name . '%');
        });
//        dd($constParnets->get());
        return DataTables::of($services)
            ->addColumn('actions', function ($service) {
                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="'.route('service.update_from',['service'=>$service->id]).'">تعديل</a>
                                                <a class="dropdown-item" href="#" onclick="delete_const(' . $service->id . ', \'' . route('service.delete') . '\')" >حذف</a>
                                            </div>
                                        </div>';

                return $element;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function add() {
        return view("CP.SystemConfig.services_add", [
            'file_types' => ServiceFileType::all(),
            'specialties' => Specialties::all(),
        ]);
    }

    public function store(Request $request) {
//        dd($request->all());
        $service = Service::query()->create([
            'name' => $request->name,
            'unit' => $request->unit,
            'input' => 1,
            'specialties_id' => $request->specialties_id,
        ]);
        $service->file_type()->attach($request->file_ids);

        return response()->json([
            'message' => 'تمت العملية بنجاح',
            'success' => true
        ]);
//        return back()->with(['success' => 'تمت عمليه الإضافة بنجاح']);
    }

    public function delete(Request $request)
    {
        Service::query()->find(request('id'))->delete();
        return response()->json([
            'message' => 'تمت عمليه الحذف  بنجاح',
            'success' => true
        ]);
    }


    public function update_from(Request $request,Service $service)
    {
        $service->load('file_type');
        $data['service']=$service;
        $data['file_types'] = ServiceFileType::all();
        $data['specialties'] = Specialties::all();

        return view('CP.SystemConfig.services_update', $data);
    }
    public function update(Request $request)
    {
        $service = Service::query()->where('id', $request->id)->firstOrFail();
        $service->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'input' => 1,
            'specialties_id' => $request->specialties_id,
        ]);
        $service->file_type()->sync($request->file_ids);

        return response()->json([
            'message' => 'تمت عمليه التعديل بنجاح',
            'success' => true
        ]);

    }
}
