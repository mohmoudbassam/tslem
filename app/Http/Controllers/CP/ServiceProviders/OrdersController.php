<?php

namespace App\Http\Controllers\CP\ServiceProviders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderSharer;
use App\Models\ServiceProviderFiles;
use App\Models\Session;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{
    public function orders()
    {
        $data['designers'] = User::query()->whereHas('designer_orders', function ($q) {
            $q->where('owner_id', auth()->user()->id);
        })->get();
        $data['consulting'] = User::query()->whereHas('consulting_orders', function ($q) {
            $q->where('owner_id', auth()->user()->id);
        })->get();
        $data['contractors'] = User::query()->whereHas('contractors_orders', function ($q) {
            $q->where('owner_id', auth()->user()->id);
        })->get();

        return view('CP.service_providers.orders', $data);
    }

    public function create_order()
    {
        $data['designers'] = User::query()->whereVitrified()->where('type', 'design_office')->get();
        return view('CP.service_providers.create_order', $data);
    }

    public function save_order(Request $request)
    {
        $order = Order::query()->create([
            "title" => Str::random(15),
            "description" => Str::random(15),
            "date" => date("Y-m-d"),
            "owner_id" => auth()->user()->id,
            "designer_id" => $request->designer_id,
            "identifier" => randomIntIdentifier()
        ]);
        $order->save();

        $sharers = User::query()->where("type", User::SHARER_TYPE)->pluck('id');
        $order->orderSharer()->saveMany($sharers->map(function ($item) {
            return new OrderSharer(["user_id" => $item]);
        }));

        save_logs($order, $request->designer_id, 'تم انشاء الطلب ');
        $user = User::query()->find($request->designer_id);

        $user->notify(new OrderNotification('تم إنشاء الطلب  ', auth()->user()->id));
        return redirect()->route('services_providers.orders')->with(['success' => 'تم انشاء الطلب بنجاح']);
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
            ->whereServiceProvider(auth()->user()->id)
            ->with(['designer', 'contractor', 'consulting']);
        return DataTables::of($order)
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })
            ->addColumn('order_status', function ($order) {
                return $order->order_status;
            })
            ->addColumn('actions', function ($order) {

                $add_designer = '';
                $add_contractor_and_consulting_office = '';
                if ($order->designer_id == null) {
                    $add_designer = '<a class="dropdown-item" href="' . route('services_providers.edit_order', ['order' => $order->id]) . '" href="javascript:;"><i class="fa fa-file mx-2"></i>إضافة مكتب تصميم </a>';
                }

                if ($order->status == Order::DESIGN_APPROVED && $order->contractor_id == null && $order->consulting_office_id == null) {
                    $add_contractor_and_consulting_office = '<a class="dropdown-item" onclick="showModal(\'' . route('services_providers.add_constructor_form', ['order' => $order->id]) . '\')" href="javascript:;"><i class="fa fa-plus mx-2"></i>إضافة استشاري ومقاول</a>';
                }

                if (empty($add_designer) && empty($add_contractor_and_consulting_office)) {
                    $element = '';
                } else {

                    $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">

                                               ' . $add_designer . '
                                               ' . $add_contractor_and_consulting_office . '

                                                </div>
                              </div>';
                }

                return $element;
            })
            ->rawColumns(['actions'])
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
        $order = tap(Order::query()->where('id', $request->order_id)->first())
            ->update($request->except('files', '_token', 'order_id'));

        save_logs($order, $request->designer_id, 'تم انشاء الطلب ');
        $user = User::query()->find($request->designer_id);

        $user->notify(new OrderNotification('تم إنشاء الطلب  ', auth()->user()->id));
        return redirect()->route('services_providers.orders')->with(['success' => 'تم تعديل الطلب بنجاح']);


    }

    public function add_constructor_form(Order $order)
    {
        $contractors = User::query()->where('type', '=', 'contractor')->get();
        $consulting_offices = User::query()->where('type', '=', 'consulting_office')->get();
        return response()->json([
            'success' => true,
            'page' => view('CP.service_providers.chice_constractor', [
                'order' => $order,
                'contractors' => $contractors,
                'consulting_offices' => $consulting_offices,
            ])->render()
        ]);

    }

    public function choice_constructor_action(Request $request)
    {

        $order = Order::query()->findOrFail($request->id);
        $order->update([
            'contractor_id' => $request->contractor_id,
            'consulting_office_id' => $request->consulting_office_id
        ]);
        save_logs($order, auth()->user()->id, "تم اخيار المشرف ومكتب المقاولات");

        optional($order->consulting)->notify(new OrderNotification('تم اختيارك كمتب استشاري على الطلب  ', auth()->user()->id));
        optional($order->contractor)->notify(new OrderNotification('تم اختيارك كمتب مقاولات على الطلب   ', auth()->user()->id));
        return response()->json([
            'success' => true,
            'message' => 'تم الاختيار بنجاح'
        ]);
    }

    public function show_appointment()
    {
        $session = Session::query()->where('user_id', auth()->user()->id)->first();

        $files = [
            [
                'name' => 'test.pdf',
                'path' => 'Mechanical.pdf'
            ], [
                'name' => 'asd.pdf',
                'path' => 'Mechanical.pdf'
            ], [
                'name' => 'ssss.pdf',
                'path' => 'Mechanical.pdf'
            ]
        ];
        return view('CP.service_providers.show_appointment', [
            'session' => $session,
            'files' => $files
        ]);
    }

    public function show_main_files()
    {
        $files = ServiceProviderFiles::query()->where('service_providers_id', auth()->user()->id)->get();
        return view('CP.service_providers.view_maintainance_files', [
            'files' => $files
        ]);
    }

    public function seen_maintain_file()
    {
        auth()->user()->update([
            'service_provider_status' => 3
        ]);
        return redirect()->route('services_providers.orders');
    }

}
