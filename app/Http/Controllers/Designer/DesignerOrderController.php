<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DesignerOrderController extends Controller
{
    public function orders(){
       return view('CP.designer.orders');
    }
    public function list(){
        $order = Order::query()->whereDesigner(auth()->user()->id)->with('designer');
        return DataTables::of($order)
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })->make(true);
    }
}
