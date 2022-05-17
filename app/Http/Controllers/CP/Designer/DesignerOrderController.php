<?php

namespace App\Http\Controllers\CP\Designer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\OrderServiceFile;
use App\Models\Service;
use App\Models\ServiceFileType;
use App\Models\Specialties;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

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
        $data = $request->except(['order_id', '_token']);
        $order = Order::query()->find(request('order_id'));

        foreach ($data as $specialties => $service) {

            foreach ($service as $keys) {
                $order_service = OrderService::query()->create([
                    'service_id' => $keys['service_id'],
                    'order_id' => $order->id,
                    'unit' => $keys['unit'],
                ]);
                foreach ($keys as $key => $value) {

                    if ($type = ServiceFileType::query()->where('name_en', $key)->first()) {

                        $this->upload_files($order, $order_service, $value, $type);
                    }
                }


            }

        }


        return redirect()->back()->with('success', 'تم إضافة التصاميم بنجاح');

    }

    public function upload_files($order, $order_service, $file, $type)
    {

        $path = Storage::disk('public')->put("orders/$order->id/", $file);

        $file_name = $file->getClientOriginalName();
        OrderServiceFile::query()->create([
            'path' => $path,
            'real_name' => $file_name,
            'order_service_id' => $order_service->id,
            'type' => $type->id,
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
        $order_specialties = $order->service->groupBy('specialties.name_en');
        $order_service = OrderService::query()->with('service.order_service_file')->where('order_id', $order->id)->get();
        dd($order_service);
        return view('CP.designer.edit_files', ['order' => $order, 'specialties' => $specialties, 'services' => $service, 'order_specialties' => $order_specialties]);
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
