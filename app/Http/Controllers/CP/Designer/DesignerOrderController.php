<?php

namespace App\Http\Controllers\CP\Designer;

use App\Http\Controllers\Controller;
use App\Models\Order;
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

                if ($order->status > 1) {
                    $add_file_design = '';
                }
                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                               ' . $add_file_design . '

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

    public function accept(Request $request)
    {

        $order = Order::query()->findOrFail($request->id);
        if ($order->status == 1) {
            $order->status = Order::DESIGN_REVIEW;
            $order->save();

            save_logs($order, $order->designer_id, 'تم اعتماد الطلب  من مكتب التصميم ');

            optional($order->service_provider)->notify(new OrderNotification('تم اعتماد الطلب  من مكتب التصميم   ', $order->designer_id));
            return response()->json([
                'success' => true,
                'message' => 'تمت اعتماد الطلب بنجاح'
            ]);
        }
    }

    public function reject(Request $request)
    {

        $order = Order::query()->findOrFail($request->id);
        if ($order->status == 1) {
            $order->status = Order::PENDING;
            $order->save();

            save_logs($order, $order->designer_id, 'تم رفض الطلب من مكتب التصميم');

            optional($order->service_provider)->notify(new OrderNotification('تم رفض الطلب من مكتب التصميم', $order->designer_id));
            return response()->json([
                'success' => true,
                'message' => 'تمت رفض الطلب بنجاح'
            ]);
        }


    }

    public function add_files(Order $order)
    {
        return view('CP.designer.add_files', ['order' => $order]);
    }

    public function save_file(Request $request)
    {

      $order = Order::query()->findOrFail($request->id);

    save_logs($order,auth()->user()->id,'تم اضافة التصاميم من قبل مكتب التصميم');
      $delivery=User::query()->where('type','Delivery')->first();
        $delivery->notify(new OrderNotification('تم إنشاء الطلب',auth()->user()->id));
        $this->upload_files($order,$request);

        $order->update([
           'status'=>Order::ORDER_REVIEW
        ]);
        return response()->json([
           'success' =>true,
            'message' =>'تمت اضافة التصاميم بنجاح'
        ]);

    }

    public function upload_files($order, $request)
    {
        foreach ($request->file('files') as $file) {
            $path = Storage::disk('public')->put('order/' . $order->id, $file);
            $file_name = $file->getClientOriginalName();
            $order->file()->create([
                'path' => $path,
                'real_name' => $file_name
            ]);
        }
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
