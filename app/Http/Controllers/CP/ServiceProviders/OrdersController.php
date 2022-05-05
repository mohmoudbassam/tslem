<?php

namespace App\Http\Controllers\CP\ServiceProviders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{
    public function orders(){
        return view('CP.service_providers.orders');
    }
    public function create_order(){
        $data['designers']=User::query()->where('type','design_office')->get();
        return view('CP.service_providers.create_order',$data);
    }
    public function save_order(Request $request){
          Order::query()->create($request->all());
        return redirect()->route('services_providers')->with(['success'=>'تم انشاء الطلب بنجاح']);
    }
    public function list(Request $request){
      $order= Order::query()->with('designer');
        return DataTables::of($order)
            ->addColumn('created_at',function($order){
              return   $order->created_at->format('Y-m-d');
            })
            ->make(true);
    }
}
