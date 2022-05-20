<?php

namespace App\Http\Controllers\CP\Delivery;

use App\Http\Controllers\Controller;
use App\Models\ConsultingReport;
use App\Models\ConsultingReportAttchment;
use App\Models\DeliveryReport;
use App\Models\DeliveryReportAttchment;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\OrderService;
use App\Models\OrderSpecilatiesFiles;
class DeliveryController extends Controller
{
    public function orders()
    {
        return view('CP.delivery.orders');
    }

    public function list()
    {
        $order = Order::query()->with(['service_provider', 'designer'])->where('status', '>=', '2');
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
                                            <a class="btn btn-info btn-sm  type="button"  href="' . route('delivery.view_file', ['order' => $order->id]) . '">
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

    public function reports_view(Order $order)
    {
        return view('CP.delivery.reports_view', [
            'order' => $order
        ]);
    }

    public function reports()
    {
        return view('CP.delivery.reports');
    }

    public function reports_list(Order $order)
    {
        $reports = DeliveryReport::query()->with(['attchments'])
            ->where('user_id', '=', auth()->user()->id)
            ->where('order_id', $order->id);
        return DataTables::of($reports)
            ->addColumn('actions', function ($report) use ($order) {
                $delete = '<a class="dropdown-item" onclick="deleteReport(' . $report->id . ')" href="javascript:;"><i class="fa fa-trash"></i>حذف  </a>';
                $edit = '<a class="dropdown-item" href="' . route('delivery.report_edit_form', ['report' => $report->id]) . '"><i class="fa fa-edit"></i>تعديل  التقرير  </a>';

                if ($order->status >= 4) {
                    $delete = '';
                    $edit = '';
                }

                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                عرض<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                               ' . $delete . '
                                               ' . $edit . '
                                            </div>
                                        </div>';
                return $element;

            })
            ->addColumn('description', function ($report) {
                return Str::substr($report->description, 0, 50);
            })
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })->addColumn('order_status', function ($order) {
                return $order->order_status;
            })->rawColumns(['actions'])
            ->make(true);
    }

    public function reports_list_all()
    {
        $reports = DeliveryReport::query()->with(['attchments'])
            ->where('user_id', '=', auth()->user()->id);
        return DataTables::of($reports)
            ->addColumn('actions', function ($report){
                $delete = '<a class="dropdown-item" onclick="deleteReport(' . $report->id . ')" href="javascript:;"><i class="fa fa-trash"></i>حذف  </a>';
                $edit = '<a class="dropdown-item" href="' . route('delivery.report_edit_form', ['report' => $report->id]) . '"><i class="fa fa-edit"></i>تعديل  التقرير  </a>';


                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                               ' . $delete . '
                                               ' . $edit . '
                                            </div>
                                        </div>';
                return $element;

            })
            ->addColumn('description', function ($report) {
                return Str::substr($report->description, 0, 50);
            })
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })->addColumn('order_status', function ($order) {
                return $order->order_status;
            })->rawColumns(['actions'])
            ->make(true);
    }

    public function add_report_page(Order $order)
    {
        $order_ids = DeliveryReport::where('user_id', '=', auth()->user()->id)
        ->pluck('order_id');
        $orders = Order::select('id','title')->whereIn('id',$order_ids)->get();
        return view('CP.delivery.report_add_form', [
            'orders' => $orders,
        ]);
    }

    public function add_report(Request $request)
    {
        $report = DeliveryReport::create([
            'title' => $request->title,
            'description' => $request->description,
            'order_id' => $request->order_id,
            'user_id' => auth()->user()->id,
        ]);
        $this->upload_files($report, $request);

        return response()->json([
            'success' => true,
            'message' => 'تمت اضافة التقرير بنجاح'
        ]);
    }

    public function delete_report(Request $request)
    {
        $report = DeliveryReport::query()->where('id', $request->id)->firstOrFail();
        $report->deleteOrFail();

        return response()->json([
            'success' => true,
            'message' => 'تمت حذف التقرير بنجاح'
        ]);
    }

    public function delete_file(DeliveryReportAttchment $attchment)
    {
        $attchment->deleteOrFail();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المرفق بنجاح'
        ]);
    }

    public function edit_report_page(Request $request, DeliveryReport $report)
    {
        $report->load('attchments');
        return view('CP.delivery.report_edit_form', [
            'report' => $report,
        ]);
    }

    public function edit_report(Request $request)
    {
        $report = DeliveryReport::query()->where('id', $request->id)->firstOrFail();
        $report->title = $request->title;
        $report->description = $request->description;
        $report->save();

        $this->upload_files($report, $request);

        return response()->json([
            'success' => true,
            'message' => 'تم تعديل التقرير بنجاح'
        ]);
    }

    public function accept_form(Request $request)
    {
        $contractors = User::query()->where('type', '=', 'contractor')->get();
        $consulting_offices = User::query()->where('type', '=', 'consulting_office')->get();
        $order = Order::query()->find($request->id);
        return response()->json([
            'success' => true,
            'page' => view('CP.delivery.accept_form', [
                'order' => $order,
                'contractors' => $contractors,
                'consulting_offices' => $consulting_offices,
            ])->render()
        ]);
    }

    public function reject_form(Request $request)
    {
        $order = Order::query()->findOrFail($request->id);
        return response()->json([
            'success' => true,
            'page' => view('CP.delivery.reject_form', [
                'order' => $order,
            ])->render()
        ]);
    }

    public function accept(Request $request)
    {
        $order = Order::query()->findOrFail($request->id);
        if ($order->status == Order::DESIGN_REVIEW) {
            $order->status = Order::DESIGN_APPROVED;
            $order->save();

            save_logs($order, auth()->user()->id, 'تم اعتماد الطلب  من مكتب التسليم ');

            optional($order->service_provider)->notify(new OrderNotification('تم اعتماد الطلب  من مكتب التسليم   ', auth()->user()->id));
            optional($order->designer)->notify(new OrderNotification('تم اعتماد الطلب  من مكتب التسليم   ', auth()->user()->id));
            return response()->json([
                'success' => true,
                'message' => 'تمت اعتماد الطلب بنجاح'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'تمت اعتماد الطلب مسبقا'
        ]);
    }

    public function reject(Request $request)
    {

        $order = Order::query()->findOrFail($request->id);
        if ($order->status == Order::DESIGN_REVIEW) {
            $order->status = Order::DESIGNER_REVIEW;
            $order->deliverRejectReson()->create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'note' => $request->note,
            ]);
            $order->save();

            save_logs($order, auth()->user()->id, 'تم رفض التصاميم من مكتب التسليم');
            optional($order->service_provider)->notify(new OrderNotification('تم رفض التصاميم  من مكتب التسليم', auth()->user()->id));
            optional($order->designer)->notify(new OrderNotification('تم رفض التصاميم من مكتب التسليم', auth()->user()->id));
            return response()->json([
                'success' => true,
                'message' => 'تمت رفض الطلب بنجاح'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'تمت رفض الطلب مسبقا'
        ]);

    }

    public function upload_files($report, $request)
    {
        foreach ((array)$request->file('files') as $file) {
            $path = Storage::disk('public')->put('orders/' . $report->order_id . '/delivery_report/', $file);
            $file_name = $file->getClientOriginalName();
            $report->attchments()->create([
                'file_path' => $path,
                'real_name' => $file_name
            ]);
        }
    }

    public function view_file(Order $order)
    {

        $order_specialties = OrderService::query()->with('service.specialties')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->get();
        return view('CP.delivery.view_file', ['order' => $order, 'order_specialties' => $order_specialties, 'filess' => $files]);

    }
}
