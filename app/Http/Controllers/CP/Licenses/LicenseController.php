<?php

namespace App\Http\Controllers\CP\Licenses;

use App\Helpers\Calendar;
use App\Http\Controllers\Controller;
use App\Http\Requests\CP\License\StoreLicenseRequest;
use App\Http\Requests\CP\License\UpdateLicenseRequest;
use App\Models\License;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
        $makeTable = fn($v) => "\n<table style='width: 100%;'>\n\t<tbody>\n{$v}\n\t</tbody>\n</table>\n";

        if( is_array($value) ) {
            $table_content = [ "", "" ];

            foreach( $value as $k => $v ) {
                $table_content[ 0 ] .= static::makeTd($k);
                $table_content[ 1 ] .= static::makeTd($v);
            }

            return $makeTable(static::makeTr($table_content[ 0 ]) . static::makeTr($table_content[ 1 ]));
        }

        return $makeTable($value);
    }

    public static function getPrintData(License $license)
    {
        $makeImg = fn($src, $class = 'img') => "<img src='{$src}' class='{$class}'>";
        return [
            $makeImg(asset('images/licenses/ksa.jpg'), 'ksa-image img') => "شركة كدانة للتنمية و التطوير مركز تسليم",
            $makeImg(asset('images/licenses/logo.png'), 'logo-image img') => static::makeTable([
                                                                                                   'رقم الرخصة:' => $license->id,
                                                                                                   'تاريخها:' => $license->hijri_date,
                                                                                                   'تاريخ الإنتهاء:' => $license->hijri_expiry_date,
                                                                                               ]),
            'رخصة إضافات ( مشعر منى )' => '',
            'معلومات المستفيد:' => static::makeTable([
                                                         'اسم الجهة' => $license->raft_company_name,
                                                         'رقم المركز' => $license->raft_company_id,
                                                         'رقم المربع' => $license->box_name,
                                                         'رقم المخيم' => $license->camp_name,
                                                         'عدد الخيام' => $license->tents_count,
                                                         'عدد الحجاج' => $license->person_count,
                                                         'مساحة المخيم' => $license->camp_space,
                                                     ]) .
                static::makeTable([
                                      'خريطة Gis' => $makeImg(asset('images/licenses/map.jpg'), 'my-2 map-image img'),
                                  ]),
            'مكونات الاضافة:' => static::makeTable([
                                                       'القواطع الجبسية (م .ط)' => '-',
                                                       'المكيفات (عدد)' => '-',
                                                       'دورة المياه (عدد)' => '-',
                                                       'رشاش حريق (عدد)' => '-',
                                                   ]) .
                static::makeTable([
                                      'مخرج طوارئ (عدد)' => '-',
                                      'مضلات مقاومة للحريق (م2)' => '-',
                                      'مغاسل (عدد)' => '-',
                                      'اخرى (عدد)' => '-',
                                  ]),

            'منفذي الاعمال' => static::makeTable([
                                                     'المكتب المصمم' => '-',
                                                     'الإستشاري المشرف' => '-',
                                                     'المقاول المنفذ' => '-',
                                                     'مقاول نقل النفايات' => '-',
                                                 ]),

            'ملاحظات' => static::makeTable([
                                               'يلزم تنفيذ الأعمال بموجب الادلة الخاصة بالأعمال الاضافية والمتابعة من قبل الاستشاري المشرف بموجب ماتم اعتماده من قبل مركز تسليم ، وان تكون مطابقة للمخططات المعتمدة والمرفقة على QR' => '',
                                               'اعتماد مدير المركز' => '-',
                                               'الختم' => '',
                                               'تاريخ الطباعة' => now(),
                                               $makeImg(asset('images/licenses/qr.png'), 'my-2 qr-image img') => '',
                                           ]),
        ];
    }

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

    public function store(StoreLicenseRequest $request)
    {
        $license = License::create($request->validated());

        return redirect()
            ->route('licenses')
            ->with([ 'success' => __('general.success') ]);
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

            'data' => static::getPrintData($license),
        ]);
    }

    public function print(Request $request, License $license)
    {
        $reportHtml = view('CP.licenses.print', [
            'mode' => 'print',
            'mode_form' => 'print',
            'model' => $license,

            'data' => static::getPrintData($license),
        ])->render();

        if( $request->has('html') ) {
            return $reportHtml;
        }
        // return $reportHtml;
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

    public function list(Request $request)
    {
        $licenses = License::query()->orderBy('created_at', data_get(collect($request->get('order', [ 'desc' ]))->first(), 'dir', 'desc'))
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
                               });
                           });

        return DataTables::of($licenses)
                         ->addColumn('raft_company_id', fn(License $license) => $license->raft_company()->value('name'))
                         ->addColumn('box_raft_company_box_id', fn(License $license) => $license->box()->value('box'))
                         ->addColumn('camp_raft_company_box_id', fn(License $license) => $license->camp()->value('camp')
                         )
                         ->addColumn(
                             'date',
                             fn(License $license) => $license->date ? Calendar::make(str_before($license->getDateFormat(), ' '))->hijriDate($license->date) : "-"
                         )
                         ->addColumn(
                             'expiry_date',
                             fn(License $license) => $license->expiry_date ? Calendar::make(str_before($license->getDateFormat(), ' '))->hijriDate($license->expiry_date) : "-"
                         )
                         ->addColumn('actions', function($license) {
                             $title = __('general.datatable.fields.actions');
                             $delete_title = License::crudTrans('delete');
                             $delete_route = route('licenses.delete', [ 'license' => $license->id ]);
                             $update_title = License::crudTrans('update');
                             $update_route = route('licenses.edit', [ 'license' => $license->id ]);
                             $print_title = License::crudTrans('print');
                             $print_route = route('licenses.print', [ 'license' => $license->id ]);

                             return <<<HTML
<div class="btn-group me-1 mt-2">
    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {$title}<i class="mdi mdi-chevron-down"></i>
    </button>

    <div class="dropdown-menu" style="">
        <a class="dropdown-item" href="#" onclick="delete_model({$license->id}, '{$delete_route}')" >{$delete_title}</a>
        <a class="dropdown-item" href="{$update_route}">{$update_title}</a>
        <a class="dropdown-item" href="{$print_route}">{$print_title}</a>
    </div>
</div>
HTML;
                         })
                         ->rawColumns([ 'actions' ])
                         ->make(true);
    }

    public function delete(Request $request, License $license)
    {
        $license->delete();

        return response()->json([
                                    'message' => __('general.success'),
                                    'success' => true,
                                ]);
    }

    public function update(StoreLicenseRequest $request, License $license)
    {
        $license->update($request->validated());

        return back()->with('success', __('general.success'));
    }

    public function save_profile(UpdateLicenseRequest $request)
    {
        $license = tap(
            auth()->license()->update([
                                          'company_name' => request('company_name'),
                                          'company_type' => request('company_type'),
                                          'company_owner_name' => request('company_owner_name'),
                                          'commercial_record' => request('commercial_record'),
                                          'website' => request('website'),
                                          'responsible_name' => request('responsible_name'),
                                          'id_number' => request('id_number'),
                                          'id_date' => Carbon::parse(
                                              request('id_date')
                                          )
                                                             ->format(
                                                                 'Y-m-d'
                                                             ),
                                          'source' => request('source'),
                                          'email' => request('email'),
                                          'phone' => request('phone'),
                                          'address' => request('address'),
                                          'telephone' => request('telephone'),
                                          'city' => request('city'),
                                          'employee_number' => request('employee_number'),
                                          'commercial_file_end_date' => request(
                                              'commercial_file_end_date'
                                          ),
                                          'rating_certificate_end_date' => request(
                                              'rating_certificate_end_date'
                                          ),
                                          'profession_license_end_date' => request(
                                              'profession_license_end_date'
                                          ),
                                          'business_license_end_date' => request(
                                              'business_license_end_date'
                                          ),
                                          'social_insurance_certificate_end_date' => request(
                                              'social_insurance_certificate_end_date'
                                          ),
                                          'date_of_zakat_end_date' => request(
                                              'date_of_zakat_end_date'
                                          ),
                                          'saudization_certificate_end_date' => request(
                                              'saudization_certificate_end_date'
                                          ),
                                          'chamber_of_commerce_certificate_end_date' => request(
                                              'chamber_of_commerce_certificate_end_date'
                                          ),
                                      ])
        );
        $this->uploadlicenseFiles(auth()->license(), $request);

        return back()->with([ 'success' => __('general.success') ]);
    }
}
