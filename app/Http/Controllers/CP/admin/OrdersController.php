<?php

namespace App\Http\Controllers\CP\admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{
    public function index()
    {
        return view('CP.AdminOrder.orders');
    }

    public function trashedIndex()
    {
        return view('CP.AdminOrder.orders', ['trashedOnly' => !0, 'pageTitle' => __("attributes.deleted_order")]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function trashedList(Request $request)
    {
        return $this->list($request, !0);
    }

    /**
     * @param  bool  $trashed
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request, bool $trashed = !1)
    {
        //dd($request->all());
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
            ->whereOrderId($request->order_id)
            ->whereDesignerId($request->designer_id)
            ->whereConsultingId($request->consulting_id)
            ->whereContractorId($request->contractor_id)
            ->orderByDesc('created_at')
            ->with(['designer', 'contractor', 'consulting','service_provider'])
            ->when($request->params == 'designe_office_orders', fn ($q) => $q->whereIn('status',[Order::DESIGN_REVIEW,Order::REQUEST_BEGIN_CREATED])->whereNotNull('designer_id'));
            if($request->order_status){
                $order = $order->where('status',$request->order_status);
            }
        //$order->when($request->params == 'tasleem', function ($q) {
        //    $q->where('status', '>=', Order::DESIGN_REVIEW);
        //});
        $order->when($request->params == 'tasleem', fn ($q) => $q->taslemDashboardOrders());
        if ($request->waste_contractor) {
            $order = $order->whereWasteContractor($request->waste_contractor);
        }

        $trashed && $order->onlyTrashed();

        return DataTables::of($order)
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })
            ->addColumn('updated_at', function ($order) {
                return $order->updated_at->format('Y-m-d');
            })
            ->addColumn('order_status', function ($order) {
                return $order->order_status;
            })
            ->addColumn('actions', function (Order $order) {
                $html = "";
                if (!$order->trashed()) {
                    $route = route('Admin.Order.softDelete', ['ids' => $order->id]);
                    $html .= <<<btn
<div class="btn-group me-1 mt-2">
    <button class="btn--ajax-request btn btn-danger btn-sm" type="button" data-url="{$route}">
        ??????
    </button>
</div>
btn;
                }
                else {
                    $route = route('Admin.Order.restore', ['ids' => $order->id]);
                    $html .= <<<btn
<div class="btn-group me-1 mt-2">
    <button class="btn--ajax-request btn btn-success btn-sm" type="button" data-url="{$route}">
        ??????????????
    </button>
</div>
btn;
                }
                return "<div>$html</div>";
            })
            ->editColumn('raft_name_only', fn(Order $o) => ($o->service_provider->raft_name_only ?? ''))
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function export(Request $request)
    {

        $orders = Order::query()
            ->when(!is_null($request->query("order_identifier")), function ($query) use ($request) {
                $query->where("identifier", "LIKE", "%".$request->query("order_identifier")."%");
            })
            ->when(!is_null($request->query("from_date")), function ($query) use ($request) {
                $query->whereDate("created_at", ">=", $request->query("from_date"));
            })
            ->when(!is_null($request->query("to_date")), function ($query) use ($request) {
                $query->whereDate("created_at", "<=", $request->query("to_date"));
            })
            ->whereOrderId($request->order_id)
            ->whereDesignerId($request->designer_id)
            ->whereConsultingId($request->consulting_id)
            ->whereContractorId($request->contractor_id)
            ->whereDate($request->from_date, $request->to_date)
            ->orderByDesc('created_at')
            ->with('designer')
            ->with(['designer', 'contractor', 'consulting']);


        $orders = $orders->get();
// dd($orders->first()->service_provider->raft_name_only);
        return Excel::download(new OrdersExport($orders), 'orders.xlsx');

    }

    /**
     * Soft delete orders
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|void
     */
    public function softDelete(Request $request)
    {
        if (app()->runningInConsole()) {
            return;
        }
        $ids = $request->input('ids', []);
        !is_array($ids) && ($ids = explode(',', $ids));
        //dd($ids);
        try {
            Order::query()->whereIn('id', $ids)->get()->each->delete();
        }
        catch (\Exception $exception) {
            config('app.debug') && dd($exception);
        }
        if ($request->expectsJson()) {
            return response()->json(['message' => __("message.order_delete_success"), 'success' => !0]);
        }
        return redirect()->back();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|void
     */
    public function restore(Request $request)
    {
        if (app()->runningInConsole()) {
            return;
        }
        $ids = $request->input('ids', []);
        !is_array($ids) && ($ids = explode(',', $ids));
        try {
            Order::onlyTrashed()->whereIn('id', $ids)->get()->each->restore();
        }
        catch (\Exception $exception) {
            config('app.debug') && dd($exception);
        }
        if ($request->expectsJson()) {
            return response()->json(['message' => __("message.order_restore_success"), 'success' => !0]);
        }
        return redirect()->back();
    }
}
