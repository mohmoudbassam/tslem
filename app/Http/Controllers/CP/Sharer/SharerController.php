<?php

namespace App\Http\Controllers\CP\Sharer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderSharer;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\OrderService;
use App\Models\OrderSpecilatiesFiles;
class SharerController extends Controller
{
    public function orders()
    {
        return view('CP.sharer.orders');
    }

    public function list()
    {
        $order = Order::query()->with(['service_provider', 'designer'])->select("orders.*")->where('status', '>=', '3');
//        dd($order->get());
        return DataTables::of($order)
            ->addColumn('actions', function ($order) {
                // $accept = '';

                // $accept = '<a class="dropdown-item" onclick="showModal(\'' . route('delivery.accept_form', ['id' => $order->id]) . '\')" href="javascript:;"><i class="fa fa-check"></i>إعتماد الطلب  </a>';
                // $reject = '<a class="dropdown-item" onclick="reject(' . $order->id . ')" href="javascript:;"><i class="fa fa-times"></i>رفض  الطلب  </a>';
                // $reports_view = '<a class="dropdown-item" href="' . route('delivery.reports_view', ['order' => $order->id]) . '"><i class="fa fa-check"></i>عرض التقارير </a>';
                // $reports_add = '<a class="dropdown-item" href="' . route('delivery.report_add_form', ['order' => $order->id]) . '"><i class="fa fa-plus"></i>انشاء التقارير </a>';

                // if ($order->status > 2) {
                //     $accept = '';
                // }
                // if ($order->status > 2) {
                //     $reject = '';
                // }
                // if ($order->status == 2) {
                //     $reports_view = '';
                // }
                // if ($order->status == 2) {
                //     $reports_add = '';
                // }
                $element = '<div class="btn-group me-1 mt-2">
                                            <a class="btn btn-info btn-sm  type="button"  href="' . route('Sharer.view_file', ['order' => $order->id]) . '">
                                                عرض التفاصيل
                                            </a>
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

    public function reject_form(Request $request)
    {
        $order = Order::query()->findOrFail($request->id);
        return response()->json([
            'success' => true,
            'page' => view('CP.sharer.reject_form', [
                'order' => $order,
            ])->render()
        ]);
    }

    public function accept(Request $request)
    {
        $orderSharer = OrderSharer::query()
            ->where("order_id", $request->id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();
        $orderSharer->accepts()->create([
            'order_sharer_id' => $orderSharer->id,
        ]);

        $order = Order::query()->with(['orderSharer', 'orderSharerAccepts'])->findOrFail($request->id);
        if ($order->orderSharerAccepts->count() == $order->orderSharer->count()) {
            $order->allow_deliver = 1;
            $order->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'تمت اعتماد الطلب بنجاح'
        ]);
    }

    public function reject(Request $request)
    {
        $order = Order::query()->with('orderSharer', function ($q) use($request) {
            $q->where('user_id', auth()->user()->id);
        })->findOrFail($request->id);

        $order->orderSharer->first()->rejects()->create([
            'note' => $request->note,
        ]);
//        if ($order->status == Order::DESIGN_REVIEW) {
//            $order->delivery_notes = 1;
//            $order->deliverRejectReson()->create([
//                'order_id' => $order->id,
//                'user_id' => auth()->user()->id,
//                'note' => $request->note,
//            ]);
//            $order->save();
//
//            save_logs($order, auth()->user()->id, 'تم رفض التصاميم من مكتب التسليم');
//            optional($order->service_provider)->notify(new OrderNotification('تم رفض التصاميم  من مكتب التسليم', auth()->user()->id));
//            optional($order->designer)->notify(new OrderNotification('تم رفض التصاميم من مكتب التسليم', auth()->user()->id));
//        }
        return response()->json([
            'success' => true,
            'message' => 'تمت رفض الطلب بنجاح'
        ]);
    }

    public function view_file(Order $order)
    {

        $order_specialties = OrderService::query()->with('service.specialties')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->get();
        return view('CP.sharer.view_file', ['order' => $order, 'order_specialties' => $order_specialties, 'filess' => $files]);

    }
}
