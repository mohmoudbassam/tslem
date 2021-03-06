<?php

namespace App\Http\Controllers\CP\Sharer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderSharer;
use App\Models\OrderSharerReject;
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
        return view('CP.Sharer.orders');
    }

    public function list(Request $request)
    {
        $order = Order::query()
            ->when(!is_null($request->query("order_identifier")), function ($query) use ($request) {
                $query->where("identifier", "LIKE", "%".$request->query("order_identifier")."%");
            })
            ->when(!is_null($request->query("from_date")), function ($query) use ($request) {
                $query->whereDate("created_at", ">=", $request->query("from_date"));
            })
            ->when(!is_null($request->query("to_date")), function ($query) use ($request) {
                $query->whereDate("created_at", "<=", $request->query("to_date"));
            })
            ->with(['service_provider', 'designer'])->select("orders.*")
            ->whereOrderId($request->order_id)
            ->whereDate($request->from_date,$request->to_date)
            ->where('status', Order::DESIGN_AWAITING_GOV_APPROVE);

        return DataTables::of($order)
            ->addColumn('actions', function ($order) {

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
            'page' => view('CP.Sharer.reject_form', [
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
        $orderSharer->status = OrderSharer::ACCEPT;
        $orderSharer->save();


        $count = OrderSharer::where("order_id", $request->id)
            ->where("status", OrderSharer::ACCEPT)->count();

        if ( $count == OrderSharer::where("order_id", $request->id)->count() ) {
            Order::where("id", $request->id)->update([
                'status' => Order::ORDER_APPROVED
            ]);
        }


        $order = Order::query()->with(['orderSharer', 'orderSharerAccepts'])->findOrFail($request->id);


        $this->prepareUpdateOrderStatus($order);

        // optional($order->designer)->notify(new OrderNotification('تم اعتماد الطلب #'.$order->identifier.' من قبل '. auth()->user()->company_name, auth()->user()->id));

        return response()->json([
            'success' => true,
            'message' => 'تمت اعتماد الطلب بنجاح'
        ]);
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function prepareUpdateOrderStatus($order){
        //dd(2);
        // [A.F] Fix query collection
        $getCountOrderSharer = $order->orderSharer();
        //dd($order->id,$getCountOrderSharer->count());

        //$isSomeoneRejected =  $order->orderSharer()->where('status', OrderSharer::REJECT)->exists();
        //foreach($getCountOrderSharer->get() as $getCountOrderSharerItem){
        //    if($getCountOrderSharerItem->status == 2){
        //        $isSomeoneRejected = true;
        //    }
        //}

        // [A.F] Fix reject status
        if($order->orderSharer()->where('status', OrderSharer::REJECT)->exists()){
            $order->status = Order::DESIGN_REVIEW;
            // [A.F] Should explain `delivery_notes`
            $order->delivery_notes = 1;
            $order->allow_deliver = 0;
            $order->save();
            // [A.F] Delete all deliver reject reasons
            //$order->deliverRejectReson()->delete();
        } elseif($getCountOrderSharer->count() == $getCountOrderSharer->where('status',OrderSharer::ACCEPT)->count()){
            // [A.F] All users already accepted
            $order->allow_deliver = 1;
            $order->status = Order::DESIGN_APPROVED;
            $order->save();
        }
    }

    public function reject(Request $request)
    {
        $order_sharer = OrderSharer::query()
            ->where('order_id', $request->id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();
        $order_sharer->status = OrderSharer::REJECT;
        $order_sharer->save();

        OrderSharerReject::query()->create([
            'note' => $request->note,
            'order_sharer_id' => $order_sharer->id
        ]);

        $order = Order::query()->with(['orderSharer', 'orderSharerAccepts'])->findOrFail($request->id);


        optional($order->designer)->notify(new OrderNotification('توجد ملاحظات على تصاميم الطلب #'.$order->identifier.' والملاحظة هي '.$request->note, auth()->user()->id));

        $this->prepareUpdateOrderStatus($order);
        return response()->json([
            'success' => true,
            'message' => 'تمت إضافة الملاحظات بنجاح'
        ]);
    }

    public function view_file(Order $order)
    {

        $order_specialties = OrderService::query()->with('service.specialties')->whereHas('service')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->get();
        $order_sharer = OrderSharer::query()->where('order_id', $order->id)->where('user_id', auth()->user()->id)->first();

        return view('CP.Sharer.view_file', ['order' => $order,
            'order_specialties' => $order_specialties,
            'filess' => $files,
            'order_sharer' => $order_sharer
        ]);

    }
}
