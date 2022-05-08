<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DesignerOrderController extends Controller
{
    public function orders()
    {
        return view('CP.designer.orders');
    }

    public function list()
    {
        $order = Order::query()->whereDesigner(auth()->user()->id)->with('designer');
        return DataTables::of($order)
            ->addColumn('actions', function ($order) {

                $accept='<a class="dropdown-item" onclick="accept(' . $order->id . ', \'' . route('design_office.accept') . '\')" href="javascript:;">إعتماد الطلب  </a>';
                $accept='<a class="dropdown-item" onclick="accept(' . $order->id . ', \'' . route('design_office.accept') . '\')" href="javascript:;">رفض  الطلب  </a>';
                $accept='<a class="dropdown-item" onclick="accept(' . $order->id . ', \'' . route('design_office.accept') . '\')" href="javascript:;">عرض الطلب </a>';



            })
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })->rawColumns(['actions'])
            ->make(true);
    }

    public function accept(Request $request)
    {
        $order = Order::query()->findOrFail($request->id);
        if ($order->status == 1) {
            $order->status = 2;
            $order->save();

            save_logs($order, $order->designer_id, 'تم اعتماد الطلب  من مكتب التصميم ');

            optional($order->service_provider)->notify(new OrderNotification('تم اعتماد الطلب  من مكتب التصميم   ', $order->designer_id));
            return response()->json([
                'status' => true,
                'message' => 'تمت اعتماد الطلب بنجاح'
            ]);
        }


    }
}
