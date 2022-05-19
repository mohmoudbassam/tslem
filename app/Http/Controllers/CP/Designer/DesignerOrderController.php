<?php

namespace App\Http\Controllers\CP\Designer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\OrderServiceFile;
use App\Models\OrderSpecilatiesFiles;
use App\Models\Service;
use App\Models\ServiceFileType;
use App\Models\Specialties;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Response;

class DesignerOrderController extends Controller
{
    public function orders()
    {
        return view('CP.designer.orders');
    }

    public function list()
    {

        $order = Order::query()->with('service_provider')->whereDesigner(auth()->user()->id)->with('designer');
        return DataTables::of($order)
            ->addColumn('actions', function ($order) {
                $add_file_design = '';

                $add_file_design = '<a class="dropdown-item" href="' . route('design_office.add_files', ['order' => $order->id]) . '" href="javascript:;"><i class="fa fa-file"></i>إضافة تصاميم  </a>';
                $edit_files = '<a class="dropdown-item" href="' . route('design_office.edit_files', ['order' => $order->id]) . '" href="javascript:;"><i class="fa fa-file"></i>تعديل الملفات </a>';
                $view = '<a class="dropdown-item" href="' . route('design_office.view_file', ['order' => $order->id]) . '" href="javascript:;"><i class="fa fa-eye"></i>عرض الملفات </a>';

                if ($order->status > 2) {
                    $add_file_design = '';
                }
                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                               ' . $add_file_design . '
                                               ' . $edit_files . '
                                               ' . $view . '


                                            </div>
                                        </div>';
                return $element;
            })
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })->addColumn('order_status', function ($order) {
                return $order->order_status;
            })->rawColumns(['actions'])
            ->make(true);
    }

//    public function accept(Request $request)
//    {
//
//        $order = Order::query()->findOrFail($request->id);
//        if ($order->status == 1) {
//            $order->status = Order::DESIGN_REVIEW;
//            $order->save();
//
//            save_logs($order, $order->designer_id, 'تم اعتماد الطلب  من مكتب التصميم ');
//
//            optional($order->service_provider)->notify(new OrderNotification('تم اعتماد الطلب  من مكتب التصميم   ', $order->designer_id));
//            return response()->json([
//                'success' => true,
//                'message' => 'تمت اعتماد الطلب بنجاح'
//            ]);
//        }
//    }
//
//    public function reject(Request $request)
//    {
//
//        $order = Order::query()->findOrFail($request->id);
//        if ($order->status == 1) {
//            $order->status = Order::PENDING;
//            $order->save();
//
//            save_logs($order, $order->designer_id, 'تم رفض الطلب من مكتب التصميم');
//
//            optional($order->service_provider)->notify(new OrderNotification('تم رفض الطلب من مكتب التصميم', $order->designer_id));
//            return response()->json([
//                'success' => true,
//                'message' => 'تمت رفض الطلب بنجاح'
//            ]);
//        }
//
//
//    }

    public function add_files(Order $order)
    {
        $specialties = Specialties::with('service')->get();
        $service = Service::all();

        return view('CP.designer.add_files', ['order' => $order, 'specialties' => $specialties, 'services' => $service]);
    }

    public function save_file(Request $request)
    {

        $order = Order::query()->find(request('order_id'));
        $specialties_names = Specialties::query()->get()->pluck('name_en')->toArray();
        $data = collect($request->except('_token', 'order_id'))->map(function ($item, $key) use ($specialties_names) {
            if (in_array($key, $specialties_names)) {
                return $item;
            }
            return null;
        })->filter();

        foreach ($data as $specialties => $services) {

            foreach ($services as $service) {

                OrderService::query()->create([
                    'service_id' => $service['service_id'],
                    'order_id' => $order->id,
                    'unit' => $service['unit'],
                ]);

            }

            $specialties_obj = Specialties::query()->where('name_en', $specialties)->first();

            if ($specialties_obj) {
                if(request($specialties . '_pdf_file')){
                    $this->upload_files($order, $specialties_obj, request($specialties . '_pdf_file'),1);
                }
                if(request($specialties . '_cad_file')){
                    $this->upload_files($order, $specialties_obj, request($specialties . '_cad_file',),2);
                }
                if(request($specialties . '_docs_file')){
                    $this->upload_files($order, $specialties_obj, request($specialties . '_docs_file'),3);
                }

            }


        }

        return redirect()->route('design_office')->with('success', 'تم إضافة التصاميم بنجاح');

    }

    public function upload_files($order, $specialties, $file,$type)
    {


            $path = Storage::disk('public')->put("orders/$order->id", $file);
            $file_name = $file->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                'path' => $path,
                'real_name' => $file_name,
                'specialties_id' => $specialties->id,
                'order_id' => $order->id,
                'type'=>$type
            ]);



    }

    public function get_service_by_id($id)
    {
        return response()->json(Service::query()->find($id));
    }

    public function edit_files(Order $order)
    {
        $specialties = Specialties::with('service')->get();
        $service = Service::all();
        $order->with('service.specialties');

        $order_specialties = OrderService::query()->with('service.specialties.service' )->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $system_specialties_services = Specialties::query()->with('service')->get();
        $order_designer_files=OrderSpecilatiesFiles::query()->with('specialties')->where('order_id', $order->id)->get()->groupBy('specialties.name_en');

        return view('CP.designer.edit_files', ['order' => $order, 'specialties' => $specialties, 'system_specialties_services' => $system_specialties_services, 'order_specialties' => $order_specialties,'order_files'=>$order_designer_files]);
    }

    public function view_file(Order $order)
    {

        $order_specialties = OrderService::query()->with('service.specialties')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $files=OrderSpecilatiesFiles::query()->where('order_id',$order->id)->get();
         return view('CP.designer.view_file', ['order' => $order,'order_specialties'=>$order_specialties,'filess'=>$files]);

    }

    public function download($id)
    {
        $file = OrderSpecilatiesFiles::query()->where('id', $id)->first();

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=$file->path",
        ];

        return (new Response(Storage::disk('public')->get($file->path), 200, $headers));

    }
}


//$accept = '';
//
//$accept = '<a class="dropdown-item" onclick="accept(' . $order->id . ')" href="javascript:;"><i class="fa fa-check"></i>إعتماد الطلب  </a>';
//$reject = '<a class="dropdown-item" onclick="reject(' . $order->id . ')" href="javascript:;"><i class="fa fa-times"></i>رفض  الطلب  </a>';
//if ($order->status > 1) {
//    $accept = '';
//}
//if ($order->status > 1) {
//    $reject = '';
//}
//$element = '<div class="btn-group me-1 mt-2">
//                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
//                                                خيارات<i class="mdi mdi-chevron-down"></i>
//                                            </button>
//                                            <div class="dropdown-menu" style="">
//                                               ' . $accept . '
//                                               ' . $reject . '
//                                            </div>
//                                        </div>';
//return $element;
