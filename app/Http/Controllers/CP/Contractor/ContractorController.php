<?php

namespace App\Http\Controllers\CP\Contractor;

use App\Http\Controllers\Controller;
use App\Models\ConsultingOrders;
use App\Models\ContractorReport;
use App\Models\ContractorReportFile;
use App\Models\ContractorSpecialtiesPivot;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\OrderSpecilatiesFiles;
use App\Models\ReportComment;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;


class ContractorController extends Controller
{
    public function orders()
    {
        $data['consulting'] = User::query()->whereHas('contractors_orders', function ($q) {
            $q->where('contractor_id', auth()->user()->id);
        })->get();
        $data['service_providers'] = User::query()->whereHas('orders', function ($q) {
            $q->where('contractor_id', auth()->user()->id);
        })->get();
        $data['designers'] = User::query()->whereHas('designer_orders', function ($q) {
            $q->where('contractor_id', auth()->user()->id);
        })->get();
        return view('CP.contractors.orders', $data);
    }

    public function list(Request $request)
    {

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
            ->with(['service_provider', 'designer', 'contractor'])
            ->whereOrderId($request->order_id)
            ->whereDesignerId($request->designer_id)
            ->whereConsultingId($request->consulting_id)
            ->whereContractorId($request->contractor_id)
            ->whereServiceProviderId($request->service_provider_id)
            ->whereDate($request->from_date, $request->to_date)
            ->orderByDesc('created_at')
            ->whereContractor(auth()->user()->id);

        return DataTables::of($order)
             ->addColumn('identifier', function(Order $order) {
                 return ($order->final_report()->value('contractor_final_report_note') ?
                         '<i class="fa fa-star-of-life mx-2 text-danger" style="font-size: 8px !important;"></i>' : '') .
                     $order->identifier;
             })
            ->addColumn('actions', function ($order) {
                $add_report = '';
                $show_reports = '';
                $is_accepted = $order->is_accepted(auth()->user());
                //$add_report = $is_accepted ? '<a class="dropdown-item"  href="'.route('contractor.add_report_form', ['order' => $order->id]).'" ><i class="fa fa-plus"></i>إضافة تقرير  </a>' : '';
                //$show_reports = $is_accepted? '<a class="dropdown-item" href="'.route('contractor.show_reports', ['order' => $order->id]).'"><i class="fa fa-eye"></i>عرض التقارير  </a>':'';
                //if ($order->status > 4) {
                //    $accept = '';
                //}
                //$accept_order='';
                //$reject_order='';
                $view_details = ' <a class="dropdown-item" href="'.route('contractor.order_details', ['order' => $order->id]).'">
                    عرض التفاصيل
                </a>';
                $accept_order = '';
                $reject_order = '';
                if (!$is_accepted) {
                    $accept_order = ' <a class="dropdown-item" href="'.route('contractor.accept_order', ['order' => $order->id]).'">
                   قبول الطلب
                </a>';
                    $reject_order = ' <a class="dropdown-item" href="'.route('contractor.reject_order', ['order' => $order->id]).'">
                  رفض الطلب
                </a>';
                }

                return <<<html
 <div class="btn-group me-1 mt-2">
    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="mdi mdi-chevron-down"></i>
      خيارات
    </button>
    <div class="dropdown-menu" style="">
       $view_details
       $accept_order
       $reject_order
       $add_report
       $show_reports
   </div>
</div>
html;

            })
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })->addColumn('order_status', function ($order) {
                return $order->order_status;
            })->rawColumns(['actions', 'identifier'])
            ->make(true);
    }

    public function list_orders(Order $order)
    {

        $reports = ContractorReport::query()
            ->where('contractor_id', '=', auth()->user()->id)
            ->where('order_id', $order->id);

        return DataTables::of($reports)
            ->addColumn('actions', function ($report) use ($order) {
                // $add_report = '';

                // $add_report = '<a class="dropdown-item"  href="' . route('contractor.add_report_form', ['order' => $order->id]) . '" ><i class="fa fa-plus"></i>إضافة تقرير  </a>';
                // $show_comments = '<a class="dropdown-item" href="' . route('contractor.show_comments', ['report' => $report->id]) . '"><i class="fa fa-eye"></i>عرض الملاحظات  </a>';
                // if ($order->status > 4) {
                //     $accept = '';
                // }

                $element = '<div class="btn-group me-1 mt-2">
                                            <a class="btn btn-info btn-sm" href="'.route('contractor.show_comments', ['report' => $report->id]).'">
                                               عرض الملاحظات
                                            </a>

                                        </div>';
                return $element;


            })
            ->addColumn('created_at', function ($order) {
                return (!is_null($order->created_at)) ? $order->created_at->format('Y-m-d') : '';
            })->addColumn('order_status', function ($order) {
                return $order->order_status;
            })->rawColumns(['actions'])
            ->make(true);
    }

    public function add_report_from(Order $order)
    {
        if ($order->contractor_id != auth()->user()->id) {
            abort(404);
        }
        return view('CP.contractors.add_report', ['order' => $order]);
    }

    public function order_details(Order $order)
    {
        $order_specialties = OrderService::query()->with('service.specialties')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->get();
        return view('CP.contractors.order_details', [
            'order'             => $order,
            'order_specialties' => $order_specialties,
            'filess'            => $files,
        ]);
    }

    public function add_edit_report(Request $request)
    {
        $order = Order::query()->where('id', $request->order_id)
            ->where('contractor_id', auth()->user()->id)
            ->firstOrFail();
        $report = ContractorReport::query()->create([
            'title'         => $request->title,
            'description'   => $request->description,
            'order_id'      => $order->id,
            'contractor_id' => auth()->id(),
        ]);
        $this->upload_files($report, $request);

        return redirect()->route('contractor.edit_report_form', ['report' => $report->id])->with('success', 'تمت عمليه الإضافة بنجاح');
        //return redirect()->route('contractor.order_details', ['order' => $order->id])->with('success', 'تمت عمليه الإضافة بنجاح');
        //return back()->with('success', 'تمت عمليه الإضافة بنجاح');
    }

    public function upload_files($report, $request)
    {
        foreach ((array) $request->file('files') as $file) {
            $path = Storage::disk('public')->put("orders/$report->order_id/contractor_report", $file);

            $file_name = $file->getClientOriginalName();
            ContractorReportFile::query()->create([
                'path'      => $path,
                'real_name' => $file_name,
                'report_id' => $report->id,
            ]);
        }
    }

    public function show_reports(Order $order)
    {
        return view('CP.contractors.show_reports', [
            'reports' => $order->contractor_report,
            'order'   => $order,
        ]);
    }

    public function report_list(Order $order)
    {
        $reports = ContractorReport::query()
            ->where('order_id', $order->id)
            ->where('contractor_id', auth()->user()->id);
        //dd($reports->count());
        $reports->latest();
        return DataTables::of($reports)
            ->addColumn('actions', function ($report) {
                $edit_report = '<a class="dropdown-item"  href="'.route('contractor.edit_report_form', ['report' => $report->id]).'" ><i class="fa fa-plus me-1"></i>تعديل التقرير  </a>';
                $delete_report = '<a class="dropdown-item" onclick="delete_report('.$report->id.' )" href="javascript:;"><i class="fa fa-times me-1"></i>حذف التقرير   </a>';
                //$show_report = '<a class="dropdown-item"  href="'.route('contractor.show', ['report' => $report->id]).'" ><i class="fa fa-plus me-1"></i>تعديل التقرير  </a>';
                //$show_comments = '<a class="dropdown-item" href="'.route('contractor.show_comments', ['report' => $report->id]).'"><i class="fa fa-times"></i>التعليقات  </a>';
                if ($report->order->status > 4) {
                    //$edit_report = '';
                    //$delete_report = '';
                }
                //$edit_report = '';
                //$delete_report = '';
                $show_report = '';

                return <<<html
<div>
    <div class="btn-group">
        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="mdi mdi-chevron-down"></i>
            خيارات
        </button>
        <div class="dropdown-menu">
           $edit_report
           $delete_report
           $show_report
        </div>
    </div>
</div>
html;

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

    public function edit_report_form(ContractorReport $report)
    {
        if ($report->contractor_id != auth()->user()->id) {
            abort(403);
        }

        return view('CP.contractors.edit_report_form', [
            'report' => $report,
            'order' => $report->order,
        ]);
    }

    public function delete_file(Request $request)
    {
        ContractorReportFile::query()->findOrFail($request->file)->delete();
        return response()->json([
            'success' => true,
        ]);
    }

    public function update_report(Request $request)
    {
        $contractorReport = ContractorReport::query()->findOrFail($request->report_id);
        $contractorReport->update([
            'title'       => $request->title,
            'description' => $request->description,
        ]);
        $this->upload_files($contractorReport, $request);
        return redirect()->back()->with(['success' => 'تم تعديل التقرير بنجاح']);
    }

    public function delete_report(Request $request)
    {
        ContractorReport::query()->findOrFail($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'تمت عمليه الحذف بنجاح',
        ]);
    }

    public function show_comments(ContractorReport $report)
    {

        return view('CP.contractors.view_comment', [
            'comments' => $report->comments()->orderByDesc('created_at')->with('user')->get(),
            'report'   => $report,
        ]);
    }

    public function save_comment(Request $request)
    {
        ReportComment::query()->create([
            'body'      => $request->body,
            'user_id'   => auth()->user()->id,
            'report_id' => $request->report_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة التعليق بنجاح',
        ]);

        //return redirect()->back()->with(['success' => 'تمت إضافة التعليق بناح']);
    }

    public function download($id)
    {
        $file = ContractorReportFile::query()->where('id', $id)->first();

        $headers = [
            'Content-Type'        => 'application/json',
            'Content-Disposition' => "attachment; filename=$file->real_name",
        ];

        return (new Response(Storage::disk('public')->get($file->path), 200, $headers));
    }

    public function accept_order(Order $order)
    {
        ConsultingOrders::create([
            'order_id' => $order->id,
            'user_id'  => auth()->user()->id,
        ]);

        if (ConsultingOrders::where('order_id', $order->id)->count() == 2) {
            $order->status = Order::ORDER_APPROVED;
            $NotificationText = 'تم اعتماد الطلب #'.$order->identifier.' من المقاول والمشرف وبإنتظار اصدار الرخصة';
            $order->save();
            save_logs($order, auth()->user()->id, $NotificationText);
            optional($order->service_provider)->notify(new OrderNotification($NotificationText, auth()->user()->id));

            $getTasleemUsers = \App\Models\User::where('type', 'Delivery')->get();
            foreach ($getTasleemUsers as $taslemUser) {
                optional($taslemUser)->notify(new OrderNotification($NotificationText, auth()->user()->id));
            }
        }

        return redirect()->back()->with(['success' => 'تم قبول الطلب بنجاح']);
    }

    public function reject_order(Order $order)
    {
        $order->contractor_id = null;
        $order->save();

        return redirect()->back()->with(['success' => 'تم رفض الطلب بنجاح']);
    }

    public function update_specialty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'specialty_id' => ['required', Rule::exists("contractor_specialties", "id")],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'من فضلك اختر التخصص الخاص بك',
                'success' => false,
                'errors'  => $request->specialty_id,
            ]);
        }

        ContractorSpecialtiesPivot::create([
            'user_id'        => auth()->id(),
            'specialties_id' => $request->specialty_id,
        ]);

        return response()->json([
            'message' => 'تم تحديث بيانات التخصص بنجاح',
            'success' => true,
        ]);
    }

}
