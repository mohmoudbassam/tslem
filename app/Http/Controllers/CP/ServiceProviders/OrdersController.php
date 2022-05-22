<?php

namespace App\Http\Controllers\CP\ServiceProviders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderSharer;
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
        $order->owner_id = auth()->user()->id;
        $order->save();

        $sharers = User::query()->where("type", User::SHARER_TYPE)->pluck('id');
        $order->orderSharer()->saveMany($sharers->map(function ($item) {
            return new OrderSharer(["user_id" => $item]);
        }));

        save_logs($order, $request->designer_id, 'تم انشاء الطلب ');
        $user = User::query()->find($request->designer_id);

        $user->notify(new OrderNotification('تم إنشاء الطلب  ', auth()->user()->id));
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
            })->addColumn('actions', function ($order) {

                $add_designer = '';
                $add_contractor_and_consulting_office = '';
                if ($order->designer_id == null) {
                    $add_designer = '<a class="dropdown-item" href="' . route('services_providers.edit_order', ['order' => $order->id]) . '" href="javascript:;"><i class="fa fa-file"></i>إضافة مكتب تصميم </a>';
                }
                if($order->status==Order::DESIGN_APPROVED && $order->contractor_id==null && $order->consulting_office_id==null){
                    $add_contractor_and_consulting_office='<a class="dropdown-item" href="' . route('services_providers.edit_order', ['order' => $order->id]) . '" href="javascript:;"><i class="fa fa-file"></i>إضافة استشاري ومقاول</a>';
                }


                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">

                                               ' . $add_designer . '

                                                </div>
                              </div>';
                return $element;
            })->rawColumns(['actions'])
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

    public function edit_order(Order $order)
    {
        $data['designers'] = User::query()
            ->whereVitrified()->where('type', 'design_office')->get();
        $data['order'] = $order;

        return view('CP.service_providers.edit_order', $data);
    }
    public function update_order(Request $request)
    {
        $order = tap(Order::query()->where('id',$request->order_id)->first())
            ->update($request->except('files', '_token','order_id'));

        save_logs($order, $request->designer_id, 'تم انشاء الطلب ');
        $user = User::query()->find($request->designer_id);

        $user->notify(new OrderNotification('تم إنشاء الطلب  ', auth()->user()->id));
        return redirect()->route('services_providers')->with(['success' => 'تم تعديل الطلب بنجاح']);


    }
}
