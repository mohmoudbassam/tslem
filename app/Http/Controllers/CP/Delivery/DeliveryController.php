<?php

namespace App\Http\Controllers\CP\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DeliveryController extends Controller
{
    public function orders()
    {
        return view('CP.delivery.orders');
    }

    public function list()
    {
        $order = Order::query()->with(['service_provider', 'designer'])->where('status', '>=', '2');
        return DataTables::of($order)
            ->addColumn('actions', function ($order) {
                $accept = '';

                $accept = '<a class="dropdown-item" onclick="showModal(\'' . route('delivery.accept_form', ['id' => $order->id]) . '\')" href="javascript:;"><i class="fa fa-check"></i>إعتماد الطلب  </a>';
                $reject = '<a class="dropdown-item" onclick="reject(' . $order->id . ')" href="javascript:;"><i class="fa fa-times"></i>رفض  الطلب  </a>';
                if ($order->status > 2) {
                    $accept = '';
                }
                if ($order->status > 2) {
                    $reject = '';
                }
                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                               ' . $accept . '
                                               ' . $reject . '
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

    public function accept_form(Request $request)
    {
        $contractors = User::query()->where('type','=', 'contractor')->get();
        $consulting_offices = User::query()->where('type', '=','consulting_office')->get();
        $order = Order::query()->find($request->id);
        return response()->json([
            'success' => true,
            'page' => view('CP.delivery.accept_form', [
                'order' => $order,
                'contractors' => $contractors,
                'consulting_offices' => $consulting_offices,
            ])->render()
        ]);
    }

    public function accept(Request $request)
    {

        $order = Order::query()->findOrFail($request->id);
        if ($order->status == 2) {
            $order->status = Order::DESIGN_APPROVED;
            $order->contractor_id = $request->contractor_id;
            $order->consulting_office_id = $request->consulting_office_id;
            $order->save();

            save_logs($order, auth()->user()->id, 'تم اعتماد الطلب  من مكتب التسليم ');

            optional($order->service_provider)->notify(new OrderNotification('تم اعتماد الطلب  من مكتب التسليم   ', $order->designer_id));
            return response()->json([
                'success' => true,
                'message' => 'تمت اعتماد الطلب بنجاح'
            ]);
        }
    }

    public function reject(Request $request)
    {

        $order = Order::query()->findOrFail($request->id);
        if ($order->status == 2) {
            $order->status = Order::DESIGN_REVIEW;
            $order->save();

            save_logs($order, auth()->user()->id, 'تم رفض التصاميم من مكتب التسليم');
            optional($order->service_provider)->notify(new OrderNotification('تم رفض التصاميم  من مكتب التسليم', auth()->user()->id));
            optional($order->designer)->notify(new OrderNotification('تم رفض التصاميم من مكتب التسليم', auth()->user()->id));
            return response()->json([
                'success' => true,
                'message' => 'تمت رفض الطلب بنجاح'
            ]);
        }


    }
}
