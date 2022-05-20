<?php

namespace App\Http\Controllers\CP\Designer;

use App\Http\Controllers\Controller;
use App\Models\DesignerRejected;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\OrderServiceFile;
use App\Models\OrderSpecilatiesFiles;
use App\Models\Service;
use App\Models\ServiceFileType;
use App\Models\Specialties;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Response;

class DesignerOrderController extends Controller
{
    public function orders()
    {
        return view('CP.designer.orders');
    }

    public function list()
    {

        $order = Order::query()->with('service_provider')->whereDesigner(auth()->user()->id)->with('designer');
        return DataTables::of($order)
            ->addColumn('actions', function ($order) {
                $add_file_design = '';

                $add_file_design = '';
                $edit_files = '<a class="dropdown-item" href="' . route('design_office.edit_files', ['order' => $order->id]) . '" href="javascript:;"><i class="fa fa-file"></i>تعديل الملفات </a>';
                $view = '<a class="dropdown-item" href="' . route('design_office.view_file', ['order' => $order->id]) . '" href="javascript:;"><i class="fa fa-eye"></i>عرض الطلب </a>';

                if ($order->status == Order::REQUEST_BEGIN_CREATED) {
                    $add_file_design = '<a class="dropdown-item" href="' . route('design_office.add_files', ['order' => $order->id]) . '" href="javascript:;"><i class="fa fa-file"></i>إضافة تصاميم  </a>';
                }

                if ($order->status == Order::REQUEST_BEGIN_CREATED) {
                    $edit_files = '<a class="dropdown-item" href="' . route('design_office.edit_files', ['order' => $order->id]) . '" href="javascript:;"><i class="fa fa-file"></i>تعديل الملفات </a>';
                }


                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">

                                               ' . $view . '
                                               ' . $add_file_design . '

                                                </div>
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

    public function accept(Order $order)
    {

        if ($order->status == Order::PENDING) {
            $order->status = Order::REQUEST_BEGIN_CREATED;
            $order->save();
            save_logs($order, $order->designer_id, 'تم اعتماد الطلب  من مكتب التصميم ');
            optional($order->service_provider)->notify(new OrderNotification('تم اعتماد الطلب  من مكتب التصميم   ', $order->designer_id));
            return redirect()->route('design_office');
        }
        return redirect()->route('design_office')->with(['success' => 'تمت الموافقة على الطلب بنحاح']);

    }

    public function reject(Order $order)
    {


        if ($order->status == Order::PENDING) {
            $order->status = Order::PENDING;
            save_logs($order, $order->designer_id, 'تم رفض الطلب من مكتب التصميم');
            optional($order->service_provider)->notify(new OrderNotification('تم رفض الطلب من مكتب التصميم', $order->designer_id));
            $order->designer_id = null;
            DesignerRejected::query()->create([
              'order_id'=>$order->id,
                'designer_id'=>auth()->user()->id
                ]);
            $order->save();
        }
        return redirect()->route('design_office')->with(['success' => 'تمت رفض الطلب بناح ']);
    }

    public function add_files(Order $order)
    {
        $specialties = Specialties::with('service')->get();
        $service = Service::all();

        return view('CP.designer.add_files', ['order' => $order, 'specialties' => $specialties, 'services' => $service]);
    }

    public function save_file(Request $request)
    {

        $file_validation = $this->validate_file($request);
        if (!$file_validation['success']) {
            return response()->json($file_validation);
        };
        $order = Order::query()->find(request('order_id'));
        $specialties_names = Specialties::query()->get()->pluck('name_en')->toArray();
        $data = collect($request->except('_token', 'order_id'))->map(function ($item, $key) use ($specialties_names) {
            if (in_array($key, $specialties_names)) {
                return $item;
            }
            return null;
        })->filter();

        foreach ($data as $specialties => $services) {

            foreach ($services as $service) {

                OrderService::query()->create([
                    'service_id' => $service['service_id'],
                    'order_id' => $order->id,
                    'unit' => $service['unit'],
                ]);

            }

            $specialties_obj = Specialties::query()->where('name_en', $specialties)->first();

            if ($specialties_obj) {
                if (request($specialties . '_pdf_file')) {
                    $this->upload_files($order, $specialties_obj, request($specialties . '_pdf_file'), 1);
                }
                if (request($specialties . '_cad_file')) {
                    $this->upload_files($order, $specialties_obj, request($specialties . '_cad_file',), 2);
                }
                if (request($specialties . '_docs_file')) {
                    $this->upload_files($order, $specialties_obj, request($specialties . '_docs_file'), 3);
                }

            }


        }
        if (request('general_file')) {
            $path = Storage::disk('public')->put("orders/$order->id", request('general_file'));
            $file_name = request('general_file')->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                'path' => $path,
                'real_name' => $file_name,
                'specialties_id' => 1,
                'order_id' => $order->id,
                'type' => 5
            ]);
        }
        session()->put('success', 'تمت اضافة التصاميم بنجاح');
        $order->status = 3;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'تمت اضافة التصاميم بنجاح'
        ]);

    }

    public function upload_files($order, $specialties, $file, $type)
    {

        if ($file) {

            $path = Storage::disk('public')->put("orders/$order->id", $file);
            $file_name = $file->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                'path' => $path,
                'real_name' => $file_name,
                'specialties_id' => $specialties->id,
                'order_id' => $order->id,
                'type' => $type
            ]);
        }


    }

    public function get_service_by_id($id)
    {
        return response()->json(Service::query()->find($id));
    }

    public function edit_files(Order $order)
    {

        $specialties = Specialties::with('service')->get();
        $service = Service::all();
        $order->with('service.specialties');

        $order_specialties = OrderService::query()->with('service.specialties.service')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $system_specialties_services = Specialties::query()->with('service')->get();
        $order_designer_files = OrderSpecilatiesFiles::query()->with('specialties')->where('order_id', $order->id)->get()->groupBy('specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->with('specialties')->where('order_id', $order->id)->get();
        $general_file = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->where('type', 5)->first();
        return view('CP.designer.edit_files', ['order' => $order, 'specialties' => $specialties,
            'system_specialties_services' => $system_specialties_services,
            'order_specialties' => $order_specialties,
            'order_files' => $order_designer_files,
            'filess' => $files,
            'general_file' => $general_file
        ]);
    }

    public function view_file(Order $order)
    {

        $order_specialties = OrderService::query()->with('service.specialties')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->get();
        return view('CP.designer.view_file', ['order' => $order, 'order_specialties' => $order_specialties, 'filess' => $files]);

    }

    public function download($id)
    {
        $file = OrderSpecilatiesFiles::query()->where('id', $id)->first();

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=$file->path",
        ];

        return (new Response(Storage::disk('public')->get($file->path), 200, $headers));

    }

    public function delete_service(OrderService $service)
    {
        $service->delete();
        return redirect()->back();
    }

    public function delete_file(OrderSpecilatiesFiles $file)
    {
        $file->delete();
        return redirect()->back();
    }

    public function edit_file_action(Request $request)
    {

        $order = Order::query()->where('id', $request->order_id)->first();

        $file_validation = $this->validate_update_file($request, $order);
        if (!$file_validation['success']) {
            return response()->json($file_validation);
        };
        $this->validate_update_file($request, $order);
        OrderService::query()->where('order_id', $order->id)->delete();

        foreach ((array)$request->service as $service) {

            OrderService::query()->create([
                'service_id' => $service['service_id'],
                'unit' => $service['unit'],
                'order_id' => $order->id
            ]);
        }
        $specialties_names = Specialties::query()->get()->pluck('name_en')->toArray();
        $data = collect($request->except('_token', 'order_id'))->map(function ($item, $key) use ($specialties_names) {
            if (in_array($key, $specialties_names)) {
                return $item;
            }
            return null;
        })->filter();

        foreach ($data as $specialties => $services) {

            foreach ($services as $service) {

                OrderService::query()->create([
                    'service_id' => $service['service_id'],
                    'order_id' => $order->id,
                    'unit' => $service['unit'],
                ]);

            }
            $specialties_obj = Specialties::query()->where('name_en', $specialties)->first();

        }

        foreach (Specialties::all() as $specialties) {

            if (request($specialties->name_en . '_pdf_file')) {
                OrderSpecilatiesFiles::query()->whereHas('specialties', function ($q) use ($specialties) {
                    $q->where('name_en', $specialties);
                })->where('order_id', $order->id)->where('type', 1)->delete();
                $this->upload_files($order, $specialties, request($specialties->name_en . '_pdf_file'), 1);
            }
            if (request($specialties->name_en . '_cad_file')) {
                OrderSpecilatiesFiles::query()->whereHas('specialties', function ($q) use ($specialties) {
                    $q->where('name_en', $specialties);
                })->where('order_id', $order->id)->where('type', 2)->delete();
                $this->upload_files($order, $specialties, request($specialties->name_en . '_cad_file',), 2);
            }
            if (request($specialties->name_en . '_docs_file')) {
                OrderSpecilatiesFiles::query()->whereHas('specialties', function ($q) use ($specialties) {
                    $q->where('name_en', $specialties);
                })->where('order_id', $order->id)->where('type', 3)->delete();
                $this->upload_files($order, $specialties, request($specialties->name_en . '_docs_file'), 3);
            }
        }
        if (request('general_file')) {
            $general_file = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->where('type', 5)->first();
            if ($general_file) {
                $general_file->delete();
            }

            $path = Storage::disk('public')->put("orders/$order->id", request('general_file'));
            $file_name = request('general_file')->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                'path' => $path,
                'real_name' => $file_name,
                'specialties_id' => 1,
                'order_id' => $order->id,
                'type' => 5
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تمت اضافة التعديل  بنجاح'
        ]);
    }

    private function validate_file($request)
    {
        $specialties_names = Specialties::query()->get()->pluck('name_en')->toArray();
        $specialties = collect($request->except('_token', 'order_id'))->map(function ($item, $key) use ($specialties_names) {
            if (in_array($key, $specialties_names)) {
                return $item;
            }
            return null;
        })->filter()->keys();
        foreach ($specialties as $key => $_specialties) {

            if (!(request($_specialties . '_pdf_file') && request($_specialties . '_cad_file'))) {
                $name = Specialties::query()->where('name_en', $_specialties)->first()->name_ar;
                return [
                    'success' => false,
                    'message' => " الرجاء إدخال جميع ملفات $name"
                ];
            }

        }
        return [
            'success' => true
        ];
    }

    public function validate_update_file(Request $request, $order)
    {
        $specialties_names = Specialties::all()->pluck('name_ar', 'name_en')->toArray();

        $order_specialties = OrderSpecilatiesFiles::query()->with('specialties')
            ->where('order_id', $order->id)
            ->get()->pluck('specialties.name_en')->unique();
        $general_file = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->where('type', 5)->first();
        if (!($general_file || request('general_file'))) {
            return [
                'success' => false,
                'message' => "الرجاء إرفاق ملف الموقع العام "
            ];
        }

        foreach ($order_specialties as $order_special) {
            $file_count = OrderSpecilatiesFiles::query()
                ->whereHas('specialties', function ($q) use ($order_special) {
                    $q->where('name_en', $order_special);
                })
                ->where('order_id', $order->id)
                ->whereIn('type', [1, 2])->count();

            if ($file_count < 2) {

                if (!(request($order_special . '_pdf_file') || request($order_special . '_cad_file'))) {
                    $name = $specialties_names[$order_special];
                    return [
                        'success' => false,
                        'message' => " الرجاء إدخال جميع ملفات $name"
                    ];
                }

            }

        }
        return [
            'success' => true
        ];
    }
}



