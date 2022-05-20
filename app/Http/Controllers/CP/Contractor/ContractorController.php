<?php

namespace App\Http\Controllers\CP\Contractor;

use App\Http\Controllers\Controller;
use App\Models\ContractorReport;
use App\Models\ContractorReportFile;
use App\Models\Order;
use App\Models\ReportComment;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\OrderService;
use App\Models\OrderSpecilatiesFiles;
class ContractorController extends Controller
{
    public function orders()
    {
        return view('CP.contractors.orders');
    }

    public function list()
    {

        $order = Order::query()->with(['service_provider', 'designer', 'contractor'])
            ->whereContractor(auth()->user()->id)
            ->where('status', '>=', '3');

        return DataTables::of($order)
            ->addColumn('actions', function ($order) {
                // $add_report = '';

                // $add_report = '<a class="dropdown-item"  href="' . route('contractor.add_report_form', ['order' => $order->id]) . '" ><i class="fa fa-plus"></i>إضافة تقرير  </a>';
                // $show_reports = '<a class="dropdown-item" href="' . route('contractor.show_reports', ['order' => $order->id]) . '"><i class="fa fa-eye"></i>عرض التقارير  </a>';
                // if ($order->status > 4) {
                //     $accept = '';
                // }

                $element = '<div class="btn-group me-1 mt-2">
                                            <a class="btn btn-info btn-sm" href="' . route('contractor.order_details', ['order' => $order->id]) . '" >
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

    public function list_orders(Order $order)
    {

        $reports = ContractorReport::query()
            ->where('contractor_id', '=', auth()->user()->id)
            ->where('order_id', $order->id);
    
        return DataTables::of($reports)
            ->addColumn('actions', function ($report) use ($order){
                $add_report = '';

                $add_report = '<a class="dropdown-item"  href="' . route('contractor.add_report_form', ['order' => $order->id]) . '" ><i class="fa fa-plus"></i>إضافة تقرير  </a>';
                $show_comments = '<a class="dropdown-item" href="' . route('contractor.show_comments', ['report' => $report->id]) . '"><i class="fa fa-eye"></i>عرض الملاحظات  </a>';
                if ($order->status > 4) {
                    $accept = '';
                }

                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                               ' . $add_report . '
                                               ' . $show_comments . '
                                            </div>
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

    public function order_details(Order $order){
        $order_specialties = OrderService::query()->with('service.specialties')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->get();
        return view('CP.contractors.order_details', [
            'order' => $order,
            'order_specialties' => $order_specialties,
            'filess' => $files
        ]);
    }
    

    public function add_edit_report(Request $request)
    {

        $order = Order::query()->where('id', $request->order_id)
            ->where('contractor_id', auth()->user()->id)
            ->firstOrFail();


        $report = ContractorReport::query()->create([
            'title' => $request->title,
            'description' => $request->description,
            'order_id' => $order->id,
            'contractor_id' => auth()->user()->id
        ]);
        $this->upload_files($report, $request);

        return back()->with('success', 'تمت عمليه الإضافة بنجاح');
    }

    public function upload_files($report, $request)
    {
        foreach ((array)$request->file('files') as $file) {
            $path = Storage::disk('public')->put("orders/$report->order_id/contractor_report", $file);

            $file_name = $file->getClientOriginalName();
            ContractorReportFile::query()->create([
                'path' => $path,
                'real_name' => $file_name,
                'report_id' => $report->id
            ]);
        }
    }

    public function show_reports(Order $order)
    {


        return view('CP.contractors.show_reports', [
            'reports' => $order->contractor_report,
            'order' => $order
        ]);
    }

    public function report_list(Order $order)
    {

        $reports = ContractorReport::query()
            ->where('order_id', $order->id)
            ->where('contractor_id', auth()->user()->id);


        return DataTables::of($reports)
            ->addColumn('actions', function ($report) {

                $edit_report = '<a class="dropdown-item"  href="' . route('contractor.edit_report_form', ['report' => $report->id]) . '" ><i class="fa fa-plus"></i>تعديل التقرير  </a>';
                $delete_report = '<a class="dropdown-item" onclick="delete_report(' . $report->id . ' )" href="javascript:;"><i class="fa fa-times"></i>حذف التقرير   </a>';
                $show_comments = '<a class="dropdown-item" href="' . route('contractor.show_comments', ['report' => $report->id]) . '"><i class="fa fa-times"></i>التعليقات  </a>';
                if ($report->order->status > 4) {
                    $edit_report = '';
                    $delete_report = '';
                }

                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                               ' . $edit_report . '
                                               ' . $delete_report . '
                                               ' . $show_comments . '
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

    public function edit_report_form(ContractorReport $report)
    {
        if ($report->contractor_id != auth()->user()->id) {
            abort(403);
        }

        return view('CP.contractors.edit_report_form', [
            'report' => $report
        ]);
    }

    public function delete_file(Request $request)
    {
        ContractorReportFile::query()->findOrFail($request->file)->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function update_report(Request $request)
    {
        $contractorReport = ContractorReport::query()->findOrFail($request->report_id);
        $contractorReport->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        $this->upload_files($contractorReport, $request);
        return redirect()->back()->with(['success' => 'تم تعديل التقرير بنجاح']);
    }

    public function delete_report(Request $request)
    {
        ContractorReport::query()->findOrFail($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'تمت عمليه الحذف بنجاح'
        ]);
    }

    public function show_comments(ContractorReport $report)
    {

        return view('CP.contractors.view_comment',[
           'comments' =>$report->comments()->orderByDesc('created_at')->with('user')->get(),
            'report' =>$report
        ]);
    }


    public function save_comment(Request $request)
    {
        ReportComment::query()->create([
            'body' => $request->body,
            'user_id' => auth()->user()->id,
            'report_id' => $request->report_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة التعليق بنجاح'
        ]);

        //return redirect()->back()->with(['success' => 'تمت إضافة التعليق بناح']);
    }


}
