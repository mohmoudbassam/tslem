<?php

namespace App\Http\Controllers\CP\Delivery;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\ConsultingReport;
use App\Models\ConsultingReportAttchment;
use App\Models\DeliveryReport;
use App\Models\DeliveryReportAttchment;
use App\Models\Order;
use App\Models\OrderSharer;
use App\Models\OrderSharerReject;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use App\Models\OrderService;
use App\Models\OrderSpecilatiesFiles;

class DeliveryController extends Controller
{
    public function orders()
    {
        $data['designers'] = User::query()->where('type', 'design_office')->where('verified', 1)->get();
        $data['consulting'] = User::query()->whereHas('designer_types', function ($Type) {
            return $Type->where('type', 'consulting');
        })->where('verified', 1)->get();
        $data['contractors'] = User::query()->where('type', 'contractor')->where('verified', 1)->get();
        $data['services_providers'] = User::query()->where('type', 'service_provider')->where('verified', 1)->get();
        return view('CP.delivery.orders', $data);
    }

    public function list(Request $request, $flag = false)
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
            ->with(['service_provider', 'designer'])
            ->select("orders.*")
            ->whereOrderId($request->order_id)
            ->whereDesignerId($request->designer_id)
            ->whereConsultingId($request->consulting_id)
            ->whereContractorId($request->contractor_id)
            ->whereDate($request->from_date, $request->to_date)
            ->where('status', '>=', '3');
        if ($flag) {
            return $order->get();
        }
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
            })
            ->addColumn('updated_at', function ($order) {
                return $order->updated_at->format('Y-m-d');
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
            ->addColumn('actions', function ($report) {
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
        $orders = Order::select('id', 'title')->whereIn('id', $order_ids)->get();
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
        $order_starer_last_notes = OrderSharer::query()
            ->where('status', OrderSharer::REJECT)->where('order_id', $request->id)
            ->get();

        return response()->json([
            'success' => true,
            'page' => view('CP.delivery.reject_form', [
                'order' => $order,
                'order_starer_last_notes' => $order_starer_last_notes
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
            $order->delivery_notes = 1;
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

        $rejects = $order->orderSharerRejects()->with('orderSharer')->get();
        $order_specialties = OrderService::query()->with('service.specialties')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->get();
        $order_sharers = OrderSharer::query()->where('order_id', $order->id)->get();


        return view('CP.delivery.view_file', [
            'order' => $order,
            'order_specialties' => $order_specialties,
            'filess' => $files,
            'rejects' => $rejects,
            'order_sharers' => $order_sharers
        ]);

    }

    public function copy_note(Request $request)
    {

        $order = Order::query()->where('id', $request->id)->firstOrFail();

        $order->deliverRejectReson()->create([
            'order_id' => $order->id,
            'user_id' => auth()->user()->id,
            'note' => $request->note,

        ]);

        save_logs($order, auth()->user()->id, 'تم رفض التصاميم من مكتب التسليم');
        optional($order->service_provider)->notify(new OrderNotification('تم رفض التصاميم  من مكتب التسليم', auth()->user()->id));
        optional($order->designer)->notify(new OrderNotification('تم رفض التصاميم من مكتب التسليم', auth()->user()->id));

        return response()->json([
            'success' => true,
            'message' => "تم التحويل بنجاح"
        ]);
    }

    public function export(Request $request)
    {

        $orders =$this->list($request,true);
        return Excel::download(new OrdersExport($orders), 'orders.xlsx');
    }
}
