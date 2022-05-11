<?php

namespace App\Http\Controllers\CP\ServiceProviders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{
    public function orders()
    {
        return view('CP.service_providers.orders');
    }

    public function create_order()
    {
        $data['designers'] = User::query()->whereVitrified()->where('type', 'design_office')->get();

        return view('CP.service_providers.create_order', $data);
    }

    public function save_order(Request $request)
    {

        $order = Order::query()->create($request->except('files', '_token'));
        $order->owner_id=auth()->user()->id;
        $order->save();
        $this->upload_files($order, $request);
        save_logs($order, $request->designer_id, 'تم انشاء الطلب ');
        $user = User::query()->find($request->designer_id);

        $user->notify(new OrderNotification('تم إنشاء الطلب  ',auth()->user()->id));
        return redirect()->route('services_providers')->with(['success' => 'تم انشاء الطلب بنجاح']);
    }

    public function list(Request $request)
    {
        $order = Order::query()->with('designer')->whereServiceProvider(auth()->user()->id)->with('designer');
        return DataTables::of($order)
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })->addColumn('order_status', function ($order) {
                return $order->order_status;
            })

            ->make(true);
    }

    public function upload_files($order, $request)
    {

        foreach ((array)$request->file('files') as $file) {
            $path = Storage::disk('public')->put('order/' . $order->id, $file);
            $file_name = $file->getClientOriginalName();
            $order->file()->create([
                'path' => $path,
                'real_name' => $file_name
            ]);
        }
    }
}
