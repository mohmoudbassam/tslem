<?php

namespace App\Http\Controllers\CP\Delivery;

use App\Exports\OrdersExport;
use App\Exports\TaslemOrdersExport;
use App\Http\Controllers\Controller;
use App\Models\DeliveryReport;
use App\Models\DeliveryReportAttchment;
use App\Models\FinalReport;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\OrderSharer;
use App\Models\OrderSpecilatiesFiles;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

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
        $data['orderStatuses'] = Order::getOrderStatuses();

        return view('CP.delivery.orders', $data);
    }

    public function reports_view(Order $order)
    {
        return view('CP.delivery.reports_view', [
            'order' => $order,
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
            ->where('order_id', $order->id)->latest();

        return DataTables::of($reports)
            ->addColumn('actions', function ($report) use ($order) {
                $delete = '<a class="dropdown-item" onclick="deleteReport(' . $report->id . ')" href="javascript:;"><i class="fa fa-trash"></i>??????  </a>';
                $edit = '<a class="dropdown-item" href="' . route('delivery.report_edit_form', ['report' => $report->id]) . '"><i class="fa fa-edit"></i>??????????  ??????????????  </a>';

                if ($order->status >= 4) {
                    $delete = '';
                    $edit = '';
                }

                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                ??????<i class="mdi mdi-chevron-down"></i>
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
        $reports = DeliveryReport::query()->with(['attchments', 'order'])
            ->where('user_id', '=', auth()->user()->id)->latest('order_id')->latest();

        return DataTables::of($reports)
            ->addColumn('actions', function ($report) {
                $delete = '<a class="dropdown-item" onclick="deleteReport(' . $report->id . ')" href="javascript:;"><i class="fa fa-trash"></i>??????  </a>';
                $edit = '<a class="dropdown-item" href="' . route('delivery.report_edit_form', ['report' => $report->id]) . '"><i class="fa fa-edit"></i>??????????  ??????????????  </a>';

                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                ????????????<i class="mdi mdi-chevron-down"></i>
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
        //$order_ids = DeliveryReport::where('user_id', '=', auth()->user()->id)
        //    ->pluck('order_id');
        //$orders = Order::select('id', 'title')->whereIn('id', $order_ids)->get();
        $orders = static::getOrdersQuery()->pluck('id', 'identifier')->toArray();

        return view('CP.delivery.report_add_form', [
            'orders' => $orders,
        ]);
    }

    public static function getOrdersQuery(): Builder
    {
        $request = request();

        return Order::query()
            ->when(!is_null(($v = $request->input("order_status"))), fn($q) => $q->where("status", $v))
            ->when(!is_null(($v = $request->input("service_provider_id"))), fn($q) => $q->where("owner_id", $v))
            ->when(!is_null($request->query("order_identifier")), function ($query) use ($request) {
                $query->where("identifier", "LIKE", "%" . $request->query("order_identifier") . "%");
            })
            ->when(!is_null($request->query("from_date")), function ($query) use ($request) {
                $query->whereDate("created_at", ">=", $request->query("from_date"));
            })
            ->when(!is_null($request->query("to_date")), function ($query) use ($request) {
                $query->whereDate("created_at", "<=", $request->query("to_date"));
            })
            ->with(['service_provider', 'designer', 'contractor'])
            ->select("orders.*")
            ->whereOrderId($request->order_id)
            ->whereDesignerId($request->designer_id)
            ->whereConsultingId($request->consulting_id)
            ->whereContractorId($request->contractor_id)
            ->whereDate($request->from_date, $request->to_date)
            ->where('status', '>=',3)
            ->latest();
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
            'message' => '?????? ?????????? ?????????????? ??????????',
        ]);
    }

    public function upload_files($report, $request)
    {
        foreach ((array)$request->file('files') as $file) {
            $path = Storage::disk('public')->put('orders/' . $report->order_id . '/delivery_report/', $file);
            $file_name = $file->getClientOriginalName();
            $report->attchments()->create([
                'file_path' => $path,
                'real_name' => $file_name,
            ]);
        }
    }

    public function delete_report(Request $request)
    {
        $report = DeliveryReport::query()->where('id', $request->id)->firstOrFail();
        $report->deleteOrFail();

        return response()->json([
            'success' => true,
            'message' => '?????? ?????? ?????????????? ??????????',
        ]);
    }

    public function delete_file(DeliveryReportAttchment $attchment)
    {
        $attchment->deleteOrFail();

        return response()->json([
            'success' => true,
            'message' => '???? ?????? ???????????? ??????????',
        ]);
    }

    public function edit_report_page(Request $request, DeliveryReport $report)
    {
        $report->load('attchments');
        $orders = static::getOrdersQuery()->pluck('id', 'identifier')->toArray();

        return view('CP.delivery.report_edit_form', [
            'report' => $report,
            'orders' => $orders,
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
            'page' => view('CP.delivery.accept_form', [
                'order' => $order,
                'contractors' => $contractors,
                'consulting_offices' => $consulting_offices,
            ])->render(),
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
                'order_starer_last_notes' => $order_starer_last_notes,
            ])->render(),
        ]);
    }

    public function accept(Request $request)
    {
        /** @var Order $order */
        $order = Order::query()->findOrFail($request->id);
        if ($order->status == Order::DESIGN_REVIEW) {
            $order->status = Order::DESIGN_AWAITING_GOV_APPROVE;
            $order->save();
            // [A.F] Change only Rejected
            //OrderSharer::where('order_id',$request->id)->update([
            //    'status' => OrderSharer::PENDING
            //]);
            $order->orderSharerRegected()->update(['status' => OrderSharer::PENDING]);
            // Todo: [A.F] Don't use inline text, use laravel localisation instead
            $order->saveLog("approved-tsleem");
            $notificationText = "???? ???????????? ?????????? ???? ???????? ??????????";
            optional($order->service_provider)->notify(new OrderNotification($notificationText, auth()->user()->id));
            optional($order->designer)->notify(new OrderNotification($notificationText, auth()->user()->id));

            return response()->json([
                'success' => true,
                'message' => '?????? ???????????? ?????????? ??????????',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => '?????? ???????????? ?????????? ??????????',
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
            $order->saveLog("rejected-tsleem");

            optional($order->service_provider)->notify(new OrderNotification('???? ?????? ???????????????? ?????????? #' . $order->identifier . ' ???? ???????? ?????????????? ???????? ' . $request->note, auth()->user()->id));
            optional($order->designer)->notify(new OrderNotification('???? ?????? ???????????????? ?????????? #' . $order->identifier . ' ???? ???????? ?????????????? ???????? ' . $request->note, auth()->user()->id));

            return response()->json([
                'success' => true,
                'message' => '?????? ?????? ?????????? ??????????',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => '?????? ?????? ?????????? ??????????',
        ]);
    }

    public function view_file(Order $order)
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
                        'url' => route('licenses.final_report_contractor_approve', ['order' => $order->id]),
                        'text' => '????????????',
                        'status' => $order->shouldPostFinalReports() && (!$final_report->contractor_final_report_approved || $final_report->contractor_final_report_note),
                    ],
                    [
                        'type' => 'danger',
                        'url' => route('licenses.reject_form', ['order' => $order->id, 'type' => 'contractor']),
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
                        'url' => route('licenses.final_report_consulting_office_approve', ['order' => $order->id]),
                        'text' => '????????????',
                        'status' => $order->shouldPostFinalReports() && (!$final_report->consulting_office_final_report_approved || $final_report->consulting_office_final_report_note),
                    ],
                    [
                        'type' => 'danger',
                        'url' => route('licenses.reject_form', ['order' => $order->id, 'type' => 'consulting_office']),
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

        return view('CP.delivery.view_file', [
            'order' => $order,
            'final_reports' => array_filter($final_reports, 'filled'),
            'order_specialties' => $order_specialties,
            'filess' => $files,
            'rejects' => $rejects,
            'order_sharers' => $order_sharers,
            'designerNote' => $designerNote,
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
        $order->saveLog("rejected-tsleem");

        optional($order->service_provider)->notify(new OrderNotification('???? ?????? ???????????????? ?????????? #' . $order->identifier . ' ???? ???????? ?????????????? ???????? ' . $request->note, auth()->user()->id));
        optional($order->designer)->notify(new OrderNotification('???? ?????? ???????????????? ?????????? #' . $order->identifier . ' ???? ???????? ?????????????? ???????? ' . $request->note, auth()->user()->id));

        return response()->json([
            'success' => true,
            'message' => "???? ?????????????? ??????????",
        ]);
    }

    public function export(Request $request)
    {


        $orders=$this->list($request,true)
            ->select('orders.*','users.license_number','raft_company_box.box as rf_box','raft_company_box.camp as rf_camp')
            ->Leftjoin('users',function ($join){
                $join->on('users.id','orders.owner_id');
            })->Leftjoin('raft_company_box', function ($join) {
            $join->on(function ($query) {
                $query->on('users.camp_number', '=', 'raft_company_box.camp')
                    ->whereColumn('users.box_number', '=', 'raft_company_box.box')
                    ->orWhereColumn('users.license_number','=','raft_company_box.license_number');
            });
        })->get();

// dd(1);
// dd($orders->service_provider->raft_name_only);
        return Excel::download(new TaslemOrdersExport($orders), 'orders.xlsx');
    }

    public function list(Request $request, $flag = false)
    {

        $order = static::getOrdersQuery();

        //dd($order->toSql());
        if ($flag) {
            return $order;
        }

        return DataTables::of($order)
            ->addColumn('actions', function (Order $order) {
                // $accept = '';
                $element = "";

                if ($order->isDesignApproved()) {
                    return '<div class="btn-group me-1 mt-2">
                                        <a class="btn btn-success btn-sm  type="button"  href="' . route('delivery.view_file', ['order' => $order->id]) . '">
                                            ?????????? ???????? ????????????????
                                        </a>
                                    </div>';
                }

                // $accept = '<a class="dropdown-item" onclick="showModal(\'' . route('delivery.accept_form', ['id' => $order->id]) . '\')" href="javascript:;"><i class="fa fa-check"></i>???????????? ??????????  </a>';
                // $reject = '<a class="dropdown-item" onclick="reject(' . $order->id . ')" href="javascript:;"><i class="fa fa-times"></i>??????  ??????????  </a>';
                // $reports_view = '<a class="dropdown-item" href="' . route('delivery.reports_view', ['order' => $order->id]) . '"><i class="fa fa-check"></i>?????? ???????????????? </a>';
                // $reports_add = '<a class="dropdown-item" href="' . route('delivery.report_add_form', ['order' => $order->id]) . '"><i class="fa fa-plus"></i>?????????? ???????????????? </a>';

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

                if ($order->status >= Order::PENDING_OPERATION) {
                    $_title = \App\Models\License::trans('download_for_service_provider');
                    $_route = route('licenses.view_pdf', ['order' => $order->id]);
                    $view = <<<HTML
    <a class="dropdown-item " type="button" target="_blank" href="{$_route}">
        {$_title}
    </a>
HTML;
                    $element .= $view;
                }

                if ($order->status >= Order::FINAL_LICENSE_GENERATED) {
                    $_title = \App\Models\License::trans('download_execution_license_for_service_provider');
                    $_route = route('licenses.view_pdf_execution_license', ['order' => $order->id]);
                    $view = <<<HTML
    <a class="dropdown-item " type="button" target="_blank" href="{$_route}">
        {$_title}
    </a>
HTML;
                    $element .= $view;
                }

                $details_route = route('delivery.view_file', ['order' => $order->id]);
                $view_order = <<<HTML
    <a class="dropdown-item " type="button" href="{$details_route}">
        ?????? ????????????????
    </a>
HTML;

                $element = <<<HTML
<div class="btn-group me-1 mt-2">
    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        ????????????<i class="mdi mdi-chevron-down"></i>
    </button>
    <div class="dropdown-menu" style="">
    {$element}
    {$view_order}
    </div>
</div>
HTML;

                return $element;
            })
            ->addColumn('created_at', function ($order) {

                return $order->created_at->format('Y-m-d');
            })
            ->addColumn('updated_at', function ($order) {
                return $order->updated_at->format('Y-m-d');
            })->addColumn('order_status', function ($order) {
                return $order->order_status;
            })
            ->setRowClass(fn(Order $o) => $o->isNewForTaslem() ? 'alert-info' : ($o->isBackFromWarning() ? 'alert-warning' : ''))
            ->editColumn('raft_name_only', fn(Order $o) => ($o->service_provider->raft_name_only ?? ''))
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function download_obligation($id)
    {
        $file = \App\Models\OrderSpecialtyObligation::query()->where('id', $id)->first();

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=" . get_obligation_name_by_type($file->type) . ".pdf",
        ];

        return (new Response(Storage::disk('public')->get($file->path), 200, $headers));

    }

    public function download_speciality_file($id)
    {
        $file = \App\Models\OrderSpecilatiesFiles::query()->where('id', $id)->first();

        if ($file->type == 5) {
            $fileName = '?????????? ??????????';
        } elseif ($file->type == 6) {
            $fileName = '??????????';
        } elseif ($file->type == 7) {
            $fileName = '??????????';
        } else {
            $fileName = '????????';
        }
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=" . $fileName . ".pdf",
        ];

        return (new Response(Storage::disk('public')->get($file->path), 200, $headers));

    }
}
