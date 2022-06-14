<?php

namespace App\Http\Controllers\CP\admin;

use App\Exports\OrdersExport;
use App\Exports\UserExport;
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

    public function list(Request $request)
    {

        $order = Order::query()
            ->when(!is_null($request->query("order_identifier")), function ($query) use ($request) {
                $query->where("identifier", "LIKE", "%" . $request->query("order_identifier") . "%");
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

        if ($request->waste_contractor) {
            $order = $order->whereWasteContractor($request->waste_contractor);
        }

        return DataTables::of($order)
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })
            ->addColumn('order_status', function ($order) {
                return $order->order_status;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function export(Request $request)
    {

        $orders = Order::query()
            ->when(!is_null($request->query("order_identifier")), function ($query) use ($request) {
                $query->where("identifier", "LIKE", "%" . $request->query("order_identifier") . "%");
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

        return Excel::download(new OrdersExport($orders), 'orders.xlsx');

    }
}
