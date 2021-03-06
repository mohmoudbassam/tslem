<?php

namespace App\Http\Controllers\CP\Licenses;

use App\Helpers\Calendar;
use App\Http\Controllers\Controller;
use App\Http\Requests\CP\License\StoreLicenseFinalAttachmentReportRequest;
use App\Http\Requests\CP\License\StoreLicenseFinalReportRequest;
use App\Http\Requests\CP\License\StoreLicenseOrderApprovedRequest;
use App\Http\Requests\CP\License\StoreLicenseRequest;
use App\Models\FinalReport;
use App\Models\License;
use App\Models\Order;
use App\Models\RaftCompanyBox;
use App\Notifications\OrderNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class LicenseController extends Controller
{
    public static function makeTd($value)
    {
        return "\t\t\t<td>{$value}</td>\n";
    }

    public static function makeTr($value)
    {
        return "\t\t<tr>\n{$value}\n\t\t</tr>\n";
    }

    public static function makeTable($value)
    {
        if( is_array($value) ) {
            $table_content = [ "", "" ];

            foreach( $value as $k => $v ) {
                $table_content[ 0 ] .= static::makeTd($k);
                $table_content[ 1 ] .= static::makeTd($v);
            }

            return static::makeTable(static::makeTr($table_content[ 0 ]) . static::makeTr($table_content[ 1 ]));
        }

        return static::makeTable($value);
    }

    // public static function getPrintData(License $license)
    // {
    //     $makeImg = fn($src, $class = 'img') => "<img src='{$src}' class='{$class}'>";
    //     return [
    //         $makeImg(asset('images/licenses/ksa.jpg'), 'ksa-image img') => "شركة كدانة للتنمية و التطوير مركز تسليم",
    //         $makeImg(asset('images/licenses/logo.png'), 'logo-image img') => static::makeTable([
    //                                                                                                'رقم الرخصة:' => $license->id,
    //                                                                                                'تاريخها:' => $license->hijri_date,
    //                                                                                                'تاريخ الإنتهاء:' => $license->hijri_expiry_date,
    //                                                                                            ]),
    //         'رخصة إضافات ( مشعر منى )' => '',
    //         'معلومات المستفيد:' => static::makeTable([
    //                                                      'اسم الجهة' => $license->raft_company_name,
    //                                                      'رقم المركز' => $license->raft_company_id,
    //                                                      'رقم المربع' => $license->box_name,
    //                                                      'رقم المخيم' => $license->camp_name,
    //                                                      'عدد الخيام' => $license->tents_count,
    //                                                      'عدد الحجاج' => $license->person_count,
    //                                                      'مساحة المخيم' => $license->camp_space,
    //                                                  ]) .
    //             static::makeTable([
    //                                   'خريطة Gis' => $makeImg(asset('images/licenses/map.jpg'), 'my-2 map-image img'),
    //                               ]),
    //         'مكونات الاضافة:' => static::makeTable([
    //                                                    'القواطع الجبسية (م .ط)' => '-',
    //                                                    'المكيفات (عدد)' => '-',
    //                                                    'دورة المياه (عدد)' => '-',
    //                                                    'رشاش حريق (عدد)' => '-',
    //                                                ]) .
    //             static::makeTable([
    //                                   'مخرج طوارئ (عدد)' => '-',
    //                                   'مضلات مقاومة للحريق (م2)' => '-',
    //                                   'مغاسل (عدد)' => '-',
    //                                   'اخرى (عدد)' => '-',
    //                               ]),
    //
    //         'منفذي الاعمال' => static::makeTable([
    //                                                  'المكتب المصمم' => '-',
    //                                                  'الإستشاري المشرف' => '-',
    //                                                  'المقاول المنفذ' => '-',
    //                                                  'مقاول نقل النفايات' => '-',
    //                                              ]),
    //
    //         'ملاحظات' => static::makeTable([
    //                                            'يلزم تنفيذ الأعمال بموجب الادلة الخاصة بالأعمال الاضافية والمتابعة من قبل الاستشاري المشرف بموجب ماتم اعتماده من قبل مركز تسليم ، وان تكون مطابقة للمخططات المعتمدة والمرفقة على QR' => '',
    //                                            'اعتماد مدير المركز' => '-',
    //                                            'الختم' => '',
    //                                            'تاريخ الطباعة' => now(),
    //                                            $makeImg(asset('images/licenses/qr.png'), 'my-2 qr-image img') => '',
    //                                        ]),
    //     ];
    // }

    public function index()
    {
        return view('CP.licenses.index');
    }

    public function add(Request $request)
    {
        return view('CP.licenses.form', [
            'mode' => 'create',
            'mode_form' => 'store',
            'model' => null,
        ]);
    }

    public function edit(Request $request, License $license)
    {
        return view('CP.licenses.form', [
            'mode' => 'update',
            'mode_form' => 'update',
            'model' => $license,
        ]);
    }

    public function show_print(Request $request, License $license)
    {
        if( request()->has('print') ) {
            return $this->print($request, $license);
        }

        return view('CP.licenses.print', [
            'mode' => 'print',
            'mode_form' => 'print',
            'model' => $license,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\License      $license
     *
     * @return \Illuminate\Http\Response|string
     */
    public function print(Request $request, License $license)
    {
        $reportHtml = view('CP.licenses.print', [
            'mode' => 'print',
            'mode_form' => 'print',
            'model' => $license,
        ])->render();

        if( $request->has('html') ) {
            return $reportHtml;
        }

        $Arabic = new \ArPHP\I18N\Arabic();
        $p = $Arabic->arIdentify($reportHtml);

        for( $i = count($p) - 1; $i >= 0; $i -= 2 ) {
            $utf8ar = $Arabic->utf8Glyphs(substr($reportHtml, $p[ $i - 1 ], $p[ $i ] - $p[ $i - 1 ]));
            $reportHtml = substr_replace($reportHtml, $utf8ar, $p[ $i - 1 ], $p[ $i ] - $p[ $i - 1 ]);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($reportHtml, 'UTF-8');
        $pdf->setPaper('A4');

        return $pdf->stream("License-{$license->id}.pdf");
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\License      $license
     *
     * @return \Illuminate\Http\Response|string
     */
    public function download(Request $request, Order $order)
    {
        $request->merge([ 'print' => 1 ]);
        /** @var \Barryvdh\Snappy\Facades\SnappyPdf $pdf */
        $pdf = app()->make('snappy.pdf.wrapper');

        return $pdf
            ->loadView('CP.licenses.print', [
                'mode' => 'print',
                'mode_form' => 'print',
                'model' => $order->license,
            ])
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('margin-bottom', 0)
            ->setOption('enable-forms', true)
            //->setOption('grayscale', true)
            //->setOption('debug-javascript', true)
            //->setOption('page-offset', 8)
            ->setOption('encoding', 'utf-8')
            //->setOption('header-font-name', 'msyh')
            ->setOption('enable-external-links', true)
            ->download("License-{$order->license()->value('id')}.pdf");
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\License      $license
     *
     * @return \Illuminate\Http\Response|string
     */
    public function view_pdf(Request $request, Order $order)
    {
        return $this->pdf1($request,$order);
        // return $order->licenseResponse(1);
    }

    public function pdf1(Request $request, Order $order)
    {
        $filename = null;
        $license = $order->license;

        return $order->makeLicenseFile($filename,1);
    }

    public function pdf2(Request $request, Order $order)
    {
        $filename = null;
        $license = $order->license;

        return $order->makeLicenseFile($filename,2);
    }

    public function pdf(Request $request, Order $order)
    {
        $filename = null;
        $license = $order->license;

        return $order->makeLicenseFile($filename,$license->type);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\License      $license
     *
     * @return \Illuminate\Http\Response|string
     */
    public function view_pdf_execution_license(Request $request, Order $order)
    {
        return $this->pdf2($request,$order);
        // return $order->licenseResponse(2);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\License      $license
     *
     * @return \Illuminate\Http\Response|string
     */
    public function view_html(Request $request, Order $order)
    {
        $reportHtml = view('CP.licenses.print', [
            'mode' => 'print',
            'mode_form' => 'print',
            'model' => $order->license,
        ])->render();

        if( $request->has('html') ) {
            return $reportHtml;
        }

        /** @var \Barryvdh\Snappy\Facades\SnappyPdf $pdf */
        $pdf = app()->make('snappy.pdf.wrapper');

        return $pdf
            ->loadHtml($reportHtml)
            ->setPaper('a4', 'portrait')
            ->setOption('margin-bottom', 0)
            ->setOption('enable-forms', false)
            // ->setOption('grayscale', true)
            ->setOption('debug-javascript', true)
            ->setOption('page-offset', 8)
            ->setOption('encoding', 'utf-8')
            //->setOption('header-font-name', 'msyh')
            ->setOption('enable-external-links', true)
            ->inline("License-{$order->license()->value('id')}.pdf");
    }

    public function list(Request $request)
    {
        $licenses = License::query()
                           ->onlyFullyCreated()
                           ->orderBy('created_at', data_get(collect($request->get('order', [ 'desc' ]))->first(), 'dir', 'desc'))
                           ->when(request('name'), function($query) {
                               return $query->where(function(Builder $q) {
                                   $columns = [
                                       'id',
                                       'tents_count',
                                       'person_count',
                                       'camp_space',
                                   ];
                                   foreach( $columns as $column ) {
                                       $q = $q->orWhere($column, 'like', '%' . request('name') . '%');
                                   }

                                   return $q;
                               })->orWhereHas('order', fn($q) => $q->where('identifier', request('name')));
                           });

        return DataTables::of($licenses)
                         ->addColumn('id', fn(License $license) => $license->id)
                         ->addColumn('order_id', fn(License $license) => $license->order()->value('identifier'))
                         ->addColumn(
                             'date',
                             fn(License $license) => ($license->type === License::ADDON_TYPE ? $license->hijri_date : $license->hijri_second_date) ?: "-"
                         )
                         ->addColumn(
                             'expiry_date',
                             fn(License $license) => $license->expiry_date ? Calendar::make(str_before($license->getDateFormat(), ' '))->hijriDate($license->expiry_date) : "-"
                         )
                         ->addColumn('raft_company', fn(License $license) => $license->raft_company_name ?? "")
                         ->addColumn('box_raft_company_box_id', fn(License $license) => $license->box()->value('box'))
                         ->addColumn('camp_raft_company_box_id', fn(License $license) => $license->camp()->value('camp'))
                         ->addColumn('actions', function($license) {
                             $title = __('general.datatable.fields.actions');
                             $delete_title = License::crudTrans('delete');
                             $delete_route = route('licenses.delete', [ 'license' => $license->id ]);
                             $update_title = License::crudTrans('update');
                             $update_route = route('licenses.edit', [ 'license' => $license->id ]);
                             $actions = '';
                             if( $license->isFullyCreated() && $license->order_id ) {
                                 $print_title = License::trans('download_for_service_provider');
                                 $print_route = route('licenses.view_pdf', [ 'order' => $license->order_id ]);
                                 $actions .= <<<HTML
<a class="dropdown-item" target="_blank" href="{$print_route}">{$print_title}</a>
HTML;
                             }

                             if( $license->type === $license::EXECUTION_TYPE && $license->order_id ) {
                                 $print_title = License::trans('download_execution_license_for_service_provider');
                                 $print_route = route('licenses.view_pdf_execution_license', [ 'order' => $license->order_id ]);
                                 $actions .= <<<HTML
<a class="dropdown-item" target="_blank" href="{$print_route}">{$print_title}</a>
HTML;
                             }

                             $crud_options_tpl = <<<HTML
        <a class="dropdown-item" href="#" onclick="delete_model({$license->id}, '{$delete_route}')" >{$delete_title}</a>
        <a class="dropdown-item" href="{$update_route}">{$update_title}</a>
HTML;
                             $crud_options = currentUser()->isAdmin() ? $crud_options_tpl : "";

                             return <<<HTML
<div class="btn-group me-1 mt-2">
    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {$title}<i class="mdi mdi-chevron-down"></i>
    </button>

    <div class="dropdown-menu" style="">
{$crud_options}
{$actions}
    </div>
</div>
HTML;
                         })
                         ->rawColumns([ 'actions' ])
                         ->make(true);
    }

    /**
     * @post
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\License      $license
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, License $license)
    {
        $license->delete();

        return response()->json([
                                    'message' => __('general.success'),
                                    'success' => true,
                                ]);
    }

    public function order_license_form(Request $request, Order $order)
    {
        return response()->json([
                                    'page' => view('CP.licenses.form_modal', [
                                        'model' => $order,
                                        'license' => $order->getLicenseOrCreate(),
                                    ])->render(),
                                    'message' => __('general.success'),
                                    'success' => true,
                                ]);
    }

    /**
     * @post
     *
     * @param \App\Http\Requests\CP\License\StoreLicenseRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreLicenseRequest $request)
    {
        $data = $request->validated();
        $data[ 'order_id' ] ??= 0;
        $license = License::create($data);

        return redirect()
            ->route('licenses')
            ->with([ 'success' => __('general.success') ]);
    }

    /**
     * @post
     *
     * @param \App\Http\Requests\CP\License\StoreLicenseOrderApprovedRequest $request
     * @param \App\Models\Order                                              $order
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function order_license_create(StoreLicenseOrderApprovedRequest $request, Order $order)
    {
        $attachment = '';
        if( $request->attachment ) {
            $attachment = Storage::disk('public')->put('license_attachment', $request->file('attachment'));
        }
        $license = $order->saveLicense(array_merge($request->validated(), compact('attachment')));

        // Send notification to service provider
        $notificationText = 'الرخصة جاهزة للإصدار للطلب #' . $order->identifier . ' وبإنتظار اختيارك للمشرف والمقاول';
        optional($order->service_provider)->notify(new OrderNotification($notificationText, auth()->user()->id));

        $order->status = Order::PENDING_OPERATION;
        $filename = null;
        $order->generateLicenseFile($filename, 1, true, true);
        $order->save();
        $order->saveLog("license-ready");

        return response()->json([
                                    'message' => __('general.success'),
                                    'success' => true,
                                ]);

    }

    public function order_license_final_report_form(Request $request, Order $order)
    {
        return response()->json([
                                    'page' => view('CP.licenses.final_report_form', [
                                        'model' => $order,
                                        'license' => $order->getLicenseOrCreate(),
                                        'note_exist' => $order->final_report()->value('contractor_final_report_note'),
                                    ])->render(),
                                    'message' => __('general.success'),
                                    'success' => true,
                                ]);
    }

    /**
     * @post
     *
     * @param \App\Http\Requests\CP\License\StoreLicenseOrderApprovedRequest $request
     * @param \App\Models\Order                                              $order
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function order_license_final_report(Request $request, Order $order)
    {
        if( !$order->hasLicense() ) {
            return response()->json([
                                        'message' => __('general.something_went_wrong'),
                                        'success' => false,
                                    ]);
        }

        $data = $request->validate(License::$FINAL_REPORT_RULES);
        $user_type = currentUser()->isContractor() ? 'contractor' : (
        currentUser()->isConsultngOffice() ? 'consulting_office' : ""
        );
        if( !$user_type ) {
            if( currentUser()->id === $order->contractor_id ) {
                $user_type = 'contractor';
            } elseif( currentUser()->id === $order->consulting_office_id ) {
                $user_type = 'consulting_office';
            }
        }
        throw_unless($user_type, "Only Contractor & Consulting Office Are Allowed To Attach!");

        $path_column = "{$user_type}_final_report_path";
        $data[ $path_column ] = array_pull($data, 'final_report_path');
        $data[ "{$user_type}_final_report_note" ] = "";
        $data[ "{$user_type}_final_report_approved" ] = false;

        $order->getFinalReportOrCreate()
              ->fill($data)
              ->save();

        $order->status = Order::FINAL_REPORT_ATTACHED;
        $order->save();

        return response()->json([
                                    'message' => __('general.success'),
                                    'success' => true,
                                ]);
    }

    public function order_license_attach_final_report_form(Request $request, Order $order)
    {
        return response()->json([
                                    'page' => view('CP.licenses.attach_final_report_form', [
                                        'model' => $order,
                                        'license' => $order->getLicenseOrCreate(),
                                    ])->render(),
                                    'message' => __('general.success'),
                                    'success' => true,
                                ]);
    }

    /**
     * @post
     *
     * @param \App\Http\Requests\CP\License\StoreLicenseOrderApprovedRequest $request
     * @param \App\Models\Order                                              $order
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function order_license_attach_final_report(StoreLicenseFinalAttachmentReportRequest $request, Order $order)
    {
        if( !$order->hasLicense() ) {
            return response()->json([
                                        'message' => __('general.something_went_wrong'),
                                        'success' => false,
                                    ]);
        }

        $data = $request->validated();
        $data[ 'type' ] = License::EXECUTION_TYPE;
        $order->getLicenseOrCreate()
              ->fill($data)
              ->save();

        $order->status = Order::FINAL_LICENSE_GENERATED;
        $filename = null;
        $order->generateLicenseFile($filename, License::EXECUTION_TYPE, true, true);
        $order->save();

        // $request->session()->flash('success', __('general.success'));

        return response()->json([
                                    'url' => route('licenses.view_pdf_execution_license', [ 'order' => $order->id ]),
                                    'message' => __('general.success'),
                                    'success' => true,
                                ]);
    }

    public function reject_form(Request $request, Order $order, $type = null)
    {
        $type = $type ?: 'contractor';
        $note = "";
        $final_report = $order->getFinalReportOrCreate();
        if( $type ) {
            $note = $final_report->getAttribute("{$type}_final_report_note");
        }

        return response()->json([
                                    'page' => view('CP.order.reject_form', [
                                        'order' => $order,
                                        'type' => $type,

                                        'title' => 'رفض تقرير نهائي',
                                        'label' => 'سبب الرفض',
                                        'note' => $note,
                                        'url' => route('licenses.reject', [ 'order' => $order->id, 'type' => $type ]),
                                    ])->render(),
                                    'message' => __('general.success'),
                                    'success' => true,
                                ]);
    }

    public function reject(Request $request, Order $order, $type)
    {
        $type = $type ?: 'contractor';
        $final_report = $order->getFinalReportOrCreate();

        if( $type === 'contractor' ) {
            $final_report->contractor_reject($request->note, true);
        } elseif( $type === 'consulting_office' ) {
            $final_report->consulting_office_reject($request->note, true);
        }

        return $request->wantsJson() ?
            response()->json([
                                 'message' => __('general.success'),
                                 'success' => true,
                             ]) :
            back();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order        $order
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function order_final_report_contractor_approve(Request $request, Order $order)
    {
        tap($order->getFinalReportOrCreate(), function(FinalReport $final_report) {
            $final_report->contractor_approve(true, true);
            if( $final_report->isFullyApproved() ) {
                $final_report
                    ->order()
                    ->update([ 'status' => Order::FINAL_REPORT_APPROVED ]);
            }
        });

        return $request->wantsJson() ?
            response()->json([
                                 'message' => __('general.success'),
                                 'success' => true,
                             ]) :
            back();

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order        $order
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function order_final_report_consulting_office_approve(Request $request, Order $order)
    {
        tap($order->getFinalReportOrCreate(), function(FinalReport $final_report) {
            $final_report->consulting_office_approve(true, true);
            if( $final_report->isFullyApproved() ) {
                $final_report
                    ->order()
                    ->update([ 'status' => Order::FINAL_REPORT_APPROVED ]);
            }
        });

        return $request->wantsJson() ?
            response()->json([
                                 'message' => __('general.success'),
                                 'success' => true,
                             ]) :
            back();

    }

    /**
     * @post
     *
     * @param \App\Http\Requests\CP\License\StoreLicenseRequest $request
     * @param \App\Models\License                               $license
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreLicenseRequest $request, License $license)
    {
        $license->update($request->validated());

        if( $request->attachment ) {
            $path = Storage::disk('public')->put('license_attachment/', $request->file('attachment'));
            $license->attachment = $path;
            $license->save();
        }

        /** @var Order $order */
        $order = optional($license->order);
        if( $order->status >= Order::PENDING_OPERATION ) {
            $filename = null;
            $order->generateLicenseFile($filename, $license->type, true, true);
        }

        return back()->with('success', __('general.success'));
    }

    public function delete_map_path(Request $request, License $license)
    {
        $license->deleteMapPathFile(true);

        return response()->json([
                                    'success' => true,
                                    'message' => 'تم حذف المرفق بنجاح',
                                ]);
    }

    public function delete_final_attachment_path(Request $request, License $license)
    {
        $license->deleteFinalAttachmentPath(true);

        return response()->json([
                                    'success' => true,
                                    'message' => 'تم حذف المرفق بنجاح',
                                ]);
    }

    public function qr_download_files(Order $order)
    {
//        $raft_company_box = RaftCompanyBox::where('id', $raft_company_box_id)->firstOrFail();
        if( $order->license->attachment ) {
            $path = Storage::disk('public')->path($order->license->attachment);

            return Response::download($path, 'attachment.pdf');
        } else {
            $rf = $order->service_provider->getRaftCompanyBox();

            return view('CP.download_box_files', [ 'rf' => $rf ]);
        }

    }

    public function download_raft_company_file($rf_id, $file_type)
    {
        $raft_company_box = RaftCompanyBox::where('id', $rf_id)->firstOrFail();

        $path = Storage::disk('public')->path($raft_company_box->{$file_type});

        return Response::download($path, $raft_company_box->{$file_type . '_name'});
    }

    public function license_final_attachment_file(Request $request, License $license)
    {
        $filename = $license->final_attachment_path;
        $path = License::disk()->path($filename);

        return Response::file($path, [
            'Content-Type' => File::mimeType($path),
            'Content-Disposition' => 'inline; filename="' . "الملف." . File::extension($path) . '"',
        ]);
    }

    public function license_map_file(Request $request, License $license)
    {
        $filename = $license->map_path;
        $path = License::disk()->path($filename);

        return Response::file($path, [
            'Content-Type' => File::mimeType($path),
            'Content-Disposition' => 'inline; filename="' . "الخريطة." . File::extension($path) . '"',
        ]);
    }
}
