<?php

namespace App\Http\Controllers\CP\ConsultingOffice;

use App\Http\Controllers\Controller;
use App\Models\ConsultingOrders;
use App\Models\ConsultingReport;
use App\Models\ConsultingReportAttchment;
use App\Models\ContractorReport;
use App\Models\FinalReport;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\OrderSharer;
use App\Models\OrderSpecilatiesFiles;
use App\Models\ReportComment;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ConsultingOfficeController extends Controller
{
    public function orders()
    {

        $data['contractors'] = User::query()->whereHas('contractors_orders', function ($q) {
            $q->where('consulting_office_id', auth()->user()->id);
        })->get();
        $data['service_providers'] = User::query()->whereHas('orders', function ($q) {
            $q->where('consulting_office_id', auth()->user()->id);
        })->get();
        $data['designers'] = User::query()->whereHas('designer_orders', function ($q) {
            $q->where('consulting_office_id', auth()->user()->id);
        })->get();

        return view('CP.consulting_office.orders', $data);
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
            })->with(['service_provider', 'designer'])
            ->whereOrderId($request->order_id)
            ->whereDate($request->from_date, $request->to_date)
            ->where('consulting_office_id', auth()->user()->id);

        return DataTables::of($order)
            ->addColumn('actions', function ($order) {
                // $accept = '';

                // $accept = '<a class="dropdown-item" onclick="showModal(\'' . route('delivery.accept_form', ['id' => $order->id]) . '\')" href="javascript:;"><i class="fa fa-check"></i>???????????? ??????????  </a>';
                //$reports_view = '<a class="dropdown-item" href="'.route('consulting_office.reports_view', ['order' => $order->id]).'"><i class="fa fa-check"></i>?????? ???????????????? </a>';
                //$reports_add = '<a class="dropdown-item" href="'.route('consulting_office.report_add_form',$order->id).'"><i class="fa fa-plus"></i>?????????? ???????????????? </a>';
                $reports_add = '';
                $reports_view = '';
                // $view_contractor_report = '<a class="dropdown-item" href="' . route('consulting_office.view_contractor_report', ['order_id' => $order->id]) . '"><i class="fa fa-eye"></i>?????? ???????????? ?????????????? </a>';
                // $reject = '<a class="dropdown-item" onclick="reject(' . $order->id . ')" href="javascript:;"><i class="fa fa-times"></i>??????  ??????????  </a>';
                // if ($order->status > 2) {
                //     $accept = '';
                // }
                // if ($order->status > 2) {
                //     $reject = '';
                // }
                $view_details = ' <a class="dropdown-item" href="'.route('consulting_office.reports_view_details', $order).'">
                    ?????? ????????????????
                </a>';
                $accept_order = '';
                $reject_order = '';

                if (!$order->is_accepted(auth()->user())) {
                    $accept_order = ' <a class="dropdown-item" href="'.route('consulting_office.accept_order', ['order' => $order->id]).'">
                   ???????? ??????????
                </a>';
                    $reject_order = ' <a class="dropdown-item" href="'.route('consulting_office.reject_order', ['order' => $order->id]).'">
                  ?????? ??????????
                </a>';
                }

                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-chevron-down"></i>
                    ????????????
                                            </button>
                                            <div class="dropdown-menu" style="">

                                               '.$accept_order.'
                                               '.$view_details.'
                                               '.$reject_order.'
                                               '.$reports_view.'
                                               '.$reports_add.'

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

    public function contractor_list(Order $order)
    {
        $order = Order::query()->with(['service_provider', 'designer', 'contractor'])
            ->whereContractor(auth()->user()->id)
            ->where('id', $order->id)
            ->where('status', '>=', '3');

        return DataTables::of($order)
            ->addColumn('actions', function ($order) {


                $element = '<div class="btn-group me-1 mt-2">
                                            <a class="btn btn-info btn-sm" href="#">
                                               ?????? ????????????????
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
        return view('CP.consulting_office.reports_view', [
            'order' => $order,
        ]);
    }

    public function reports_view_details(Order $order)
    {

        $designerNote = $order->lastDesignerNote()->latest()->first();
        $rejects = $order->orderSharerRejects()->with('orderSharer')->get();
        $order_specialties = OrderService::query()->with('service.specialties')->whereHas('service')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->get();
        $order_sharers = OrderSharer::query()->where('order_id', $order->id)->get();

        /** @var FinalReport $final_report */
        $final_report = $order->final_report ?? optional();

        $final_reports = $order->hasFinalReport() ? [
            $final_report->hasContractorReport() ? [
                'title' => "??????????????",
                'url' => downloadFileFrom($final_report, 'contractor_final_report_path'),
                'label' => $final_report->contractor_final_report_path_label,
                'buttons' => [
                    [
                        'type' => 'success',
                        'url' => route('licenses.final_report_contractor_approve', [ 'order' => $order->id ]),
                        'text' => '????????????',
                        'status' => $order->shouldPostFinalReports() && ( !$final_report->contractor_final_report_approved || $final_report->contractor_final_report_note),
                    ],
                    [
                        'type' => 'danger',
                        'url' => route('licenses.reject_form', [ 'order' => $order->id, 'type' => 'contractor' ]),
                        'text' => '?????????? ??????????????',
                        'modal' => true,
                        'status' => $order->shouldPostFinalReports() && ($final_report->contractor_final_report_approved || !$final_report->contractor_final_report_note),
                    ],
                ],
                'info' => [
                    'has_file' => $final_report->hasContractorReport() && !$final_report->contractor_final_report_note,
                    'note' => ($note = data_get($final_report->meta, 'contractor_final_report_note') ?: $final_report->contractor_final_report_note) ?
                        __('models/final_report.last_note', compact('note')) :
                        null,
                ],
            ] : null,
            $final_report->hasConsultingOfficeFinalReport() ? [
                'title' => "???????? ??????????????",
                'url' => downloadFileFrom($final_report, 'consulting_office_final_report_path'),
                'label' => $final_report->consulting_office_final_report_path_label,
                'buttons' => [
                    [
                        'type' => 'success',
                        'url' => route('licenses.final_report_consulting_office_approve', [ 'order' => $order->id ]),
                        'text' => '????????????',
                        'status' => $order->shouldPostFinalReports() && ( !$final_report->consulting_office_final_report_approved || $final_report->consulting_office_final_report_note),
                    ],
                    [
                        'type' => 'danger',
                        'url' => route('licenses.reject_form', [ 'order' => $order->id, 'type' => 'consulting_office' ]),
                        'modal' => true,
                        'text' => '?????????? ??????????????',
                        'status' => $order->shouldPostFinalReports() && ($final_report->consulting_office_final_report_approved || !$final_report->consulting_office_final_report_note),
                    ],
                ],
                'info' => [
                    'has_file' => $final_report->hasConsultingOfficeFinalReport() && !$final_report->consulting_office_final_report_note,
                    'note' => ($note = data_get($final_report->meta, 'consulting_office_final_report_note') ?: $final_report->consulting_office_final_report_note) ?
                        __('models/final_report.last_note', compact('note')) :
                        null,
                ],
            ] : null,
        ] : [];

        return view('CP.consulting_office.delivery_view_file', [
            'order' => $order,
            'final_reports' => array_filter($final_reports, 'filled'),
            'order_specialties' => $order_specialties,
            'filess' => $files,
            'rejects' => $rejects,
            'order_sharers' => $order_sharers,
            'designerNote' => $designerNote,
        ]);
        $order_specialties = OrderService::query()->with('service.specialties')->whereHas('service')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->get();
        $rejects = $order->orderSharerRejects()->with('orderSharer')->get();
        $order_sharers = OrderSharer::query()->where('order_id', $order->id)->get();
        $designerNote = $order->lastDesignerNote()->latest()->first();

        return view('CP.consulting_office.reports_view_details', [
            'order'             => $order,
            'order_specialties' => $order_specialties,
            'filess'            => $files,
            'final_reports' => [],
            'rejects' => $rejects,
            'order_sharers' => $order_sharers,
            'designerNote' => $designerNote,
        ]);
    }


    public function reports()
    {
        return view('CP.consulting_office.reports');
    }

    public function reports_list(Order $order)
    {
        $reports = ConsultingReport::query()->with(['attchment'])
            ->where('user_id', '=', auth()->user()->id)
            ->where('order_id', $order->id)->latest();
        return DataTables::of($reports)
            ->addColumn('actions', function ($report) use ($order) {
                $delete = '<a class="dropdown-item" onclick="deleteReport('.$report->id.')" href="javascript:;"><i class="fa fa-trash me-2"></i>??????  </a>';
                $edit = '<a class="dropdown-item" href="'.route('consulting_office.report_edit_form', ['report' => $report->id]).'"><i class="fa fa-edit me-2"></i>??????????  ??????????????  </a>';

                if ($order->status >= 4) {
                    //$delete = '';
                    //$edit = '';
                }

                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-chevron-down"></i>
                                                ????????????
                                            </button>
                                            <div class="dropdown-menu" style="">
                                               '.$edit.'
                                               '.$delete.'
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

    public function reports_all_list(Request $request, Order $order)
    {
        $reports = ConsultingReport::query()->with(['attchment'])
            ->where('user_id', '=', auth()->user()->id)
            ->when($request->report_id, function ($q) use ($request) {
                $q->where('id', $request->report_id);
            })
            ->whereDate($request->from_date, $request->to_date);

        return DataTables::of($reports)
            ->addColumn('actions', function ($report) {
                $delete = '<a class="dropdown-item" onclick="deleteReport('.$report->id.')" href="javascript:;"><i class="fa fa-trash"></i>??????  </a>';
                $edit = '<a class="dropdown-item" href="'.route('consulting_office.report_edit_form', ['report' => $report->id]).'"><i class="fa fa-edit"></i>??????????  ??????????????  </a>';
                $licenses = "";

                $order = $report->order;
                if( $order->status >= Order::PENDING_OPERATION ) {
                    $_title = \App\Models\License::trans('download_for_service_provider');
                    $_route = route('licenses.view_pdf', [ 'order' => $order->id ]);
                    $view = <<<HTML
    <a class="dropdown-item "  type="button"  href="{$_route}">
        {$_title}
    </a>
HTML;
                    $licenses .= $view;
                }

                if( $order->status >= Order::FINAL_LICENSE_GENERATED ) {
                    $_title = \App\Models\License::trans('download_execution_license_for_service_provider');
                    $_route = route('licenses.view_pdf_execution_license', [ 'order' => $order->id ]);
                    $view = <<<HTML
    <a class="dropdown-item "  type="button"  href="{$_route}">
        {$_title}
    </a>
HTML;
                    $licenses .= $view;
                }

                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-chevron-down"></i>
                                                ????????????
                                            </button>
                                            <div class="dropdown-menu" style="">
                                               '.$delete.'
                                               '.$edit.'
                                               '.$licenses.'
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
        //$order_ids = ConsultingReport::where('user_id', '=', auth()->user()->id)
        //    ->pluck('order_id');
        //$orders = Order::select('id', 'title')->whereIn('id', $order_ids)->get();

        //        $orders = Order::select('id', 'title')
        //            ->where('consulting_office_id', auth()->user()->id)
        //            ->where('status', '>=', '3')
        //            ->get();
        return view('CP.consulting_office.report_add_form', [
            'order' => $order,
        ]);

    }

    public function add_report(Order $order, Request $request)
    {
        //dd($order);
        $report = ConsultingReport::create([
            'title'       => $request->title,
            'description' => $request->description,
            'order_id'    => $order->id,
            'user_id'     => auth()->user()->id,
        ]);
        $this->upload_files($report, $request);
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => '?????? ?????????? ?????????????? ??????????',
            ]);
        }
        return redirect()->route('consulting_office.reports_view_details', $order)->with('success', '?????? ?????????? ?????????????? ??????????');
    }

    public function upload_files($report, $request)
    {
        foreach ((array) $request->file('files') as $file) {
            $path = Storage::disk('public')->put('orders/'.$report->order_id.'/consulting_report/', $file);
            $file_name = $file->getClientOriginalName();
            $report->attchment()->create([
                'file_path' => $path,
                'real_name' => $file_name,
            ]);
        }
    }

    public function delete_report(Request $request)
    {
        $report = ConsultingReport::query()->where('id', $request->id)->firstOrFail();
        $report->deleteOrFail();

        return response()->json([
            'success' => true,
            'message' => '?????? ?????? ?????????????? ??????????',
        ]);
    }

    public function delete_file(ConsultingReportAttchment $attchment)
    {
        $attchment->deleteOrFail();

        return response()->json([
            'success' => true,
            'message' => '???? ?????? ???????????? ??????????',
        ]);
    }

    public function edit_report_page(Request $request, ConsultingReport $report)
    {
        $report->load('attchment', 'order');
        return view('CP.consulting_office.report_edit_form', [
            'report' => $report,
            'order'  => $report->order,
        ]);
    }

    public function edit_report(Request $request)
    {
        $report = ConsultingReport::query()->where('id', $request->id)->firstOrFail();
        $report->title = $request->title;
        $report->description = $request->description;
        $report->save();

        $this->upload_files($report, $request);

        return response()->json([
            'success' => true,
            'message' => '???? ?????????? ?????????????? ??????????',
        ]);
    }

    public function accept_form(Request $request)
    {
        $contractors = User::query()->where('type', '=', 'contractor')->get();
        $consulting_offices = User::query()->where('type', '=', 'consulting_office')->get();
        $order = Order::query()->find($request->id);
        return response()->json([
            'success' => true,
            'page'    => view('CP.consulting_office.accept_form', [
                'order'              => $order,
                'contractors'        => $contractors,
                'consulting_offices' => $consulting_offices,
            ])->render(),
        ]);
    }

    public function accept(Request $request)
    {

        $order = Order::query()->findOrFail($request->id);

        if ($order->contractor_id && $order->consulting_office_id) {
            $order->status = Order::ORDER_APPROVED;
            $order->save();
            $order->saveLog("approved-all");
            $NotificationText = "???? ???????????? ?????????? ???? ?????????????? ??????????????";
            optional($order->service_provider)->notify(new OrderNotification($NotificationText, auth()->user()->id));

            $getTasleemUsers = \App\Models\User::where('type', 'Delivery')->get();
            foreach ($getTasleemUsers as $taslemUser) {
                optional($taslemUser)->notify(new OrderNotification($NotificationText, auth()->user()->id));
            }
            return response()->json([
                'success' => true,
                'message' => '?????? ???????????? ?????????? ??????????',
            ]);

        }
        else {
            return response()->json([
                'success' => false,
                'message' => '???? ?????? ???????????? ?????????? ???? ????????, ?????? ???????? ???????????????? ?????????? ???? ???????????? ??????????',
            ]);
        }


    }

    public function complete(Request $request)
    {

        $order = Order::query()->findOrFail($request->id);
        if ($order->status == 2) {
            $order->status = Order::COMPLETED;
            $order->save();
            $order->saveLog("completed");

            optional($order->service_provider)->notify(new OrderNotification('???? ?????????? ?????????? #'.$order->identifier.' ???? ????????????', $order->consulting_office_id));
            return response()->json([
                'success' => true,
                'message' => '?????? ?????????? ?????????? ??????????',
            ]);
        }
    }

    public function reject(Request $request)
    {

        $order = Order::query()->findOrFail($request->id);
        if ($order->status == 2) {
            $order->status = Order::DESIGN_REVIEW;
            $order->save();
            $order->saveLog("rejected-tsleem");

            optional($order->service_provider)->notify(new OrderNotification('???? ?????? ???????????????? ?????????? #'.$order->identifier.' ???? ???????? ??????????????', auth()->user()->id));
            optional($order->designer)->notify(new OrderNotification('???? ?????? ???????????????? ?????????? #'.$order->identifier.' ???? ???????? ??????????????', auth()->user()->id));
            return response()->json([
                'success' => true,
                'message' => '?????? ?????? ?????????? ??????????',
            ]);
        }


    }

    public function view_contractor_report(Request $request, $order_id)
    {

        $order = Order::query()
            ->where('id', $order_id)
            ->where('consulting_office_id', auth()->user()->id)
            ->firstOrFail();
        return view('CP.consulting_office.view_contractor_report', [
            'order' => $order,
        ]);
    }

    public function contractor_report_list(Request $request, Order $order)
    {

        $reports = ContractorReport::query()
            ->where('order_id', $order->id)
            ->where('contractor_id', $order->contractor_id);


        return DataTables::of($reports)
            ->addColumn('actions', function ($report) {

                $show_comments = '<a class="dropdown-item" href="'.route('consulting_office.show_comments', ['report' => $report->id]).'"><i class="fa fa-eye"></i>??????????????????  </a>';
                if ($report->order->status > 4) {
                    $edit_report = '';
                    $delete_report = '';
                }

                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-chevron-down"></i>
                                                ????????????
                                            </button>
                                            <div class="dropdown-menu" style="">

                                               '.$show_comments.'
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

    public function show_comments(ContractorReport $report)
    {

        return view('CP.consulting_office.view_commnet', [
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

        return redirect()->back()->with(['success' => '?????? ?????????? ?????????????? ????????']);
    }

    public function accept_order(Order $order)
    {
        ConsultingOrders::create([
            'order_id' => $order->id,
            'user_id'  => auth()->user()->id,
        ]);

        if (ConsultingOrders::where('order_id', $order->id)->count() == 2) {
            $order->status = Order::ORDER_APPROVED;
            $order->save();
            $order->saveLog("approved-all");
            $NotificationText = "???? ???????????? ?????????? ???? ?????????????? ??????????????";
            optional($order->service_provider)->notify(new OrderNotification($NotificationText, auth()->user()->id));

            $getTasleemUsers = \App\Models\User::where('type', 'Delivery')->get();
            foreach ($getTasleemUsers as $taslemUser) {
                optional($taslemUser)->notify(new OrderNotification($NotificationText, auth()->user()->id));
            }
        }

        return redirect()->back()->with(['success' => '???? ???????? ?????????? ??????????']);
    }

    public function reject_order(Order $order)
    {
        $order->consulting_office_id = null;
        $order->save();

        return redirect()->back()->with(['success' => '???? ?????? ?????????? ??????????']);
    }
}
