<?php

namespace App\Models;

use App\Notifications\OrderNotification;
use App\Traits\THasPathAttribute;
use App\Traits\TModelTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    use THasPathAttribute;
    use TModelTranslation;

    /**
     * @var string
     */
    public static $DISK = 'licenses';

    public const PENDING = 1;
    public const REQUEST_BEGIN_CREATED = 2;
    public const DESIGN_REVIEW = 3;
    public const DESIGN_APPROVED = 4;
    public const PROCESSING = 5;
    public const COMPLETED = 6;
    public const PENDING_LICENSE_ISSUED = 7;
    public const DESIGN_AWAITING_GOV_APPROVE = 8;
    public const ORDER_APPROVED = 9;
    public const PENDING_OPERATION = 10;
    public const FINAL_REPORT_ATTACHED = 11;
    public const FINAL_REPORT_APPROVED = 12;
    public const FINAL_LICENSE_GENERATED = 13;
    protected $fillable = [
        'identifier',
        'title',
        'description',
        'date',
        'status',
        'owner_id',
        'designer_id',
        'delivery_notes',
        'allow_deliver',
        'contractor_id',
        'consulting_office_id',
        'waste_contractor',
        'license_paths',
        'agreed',
    ];

    protected $casts = [
        'license_paths' => 'array',
        'agreed' => 'boolean',
    ];

    public static $RULES = [
        'agreed' => [
            'boolean',
            'required',
        ],
    ];

    public function license()
    {
        return $this->hasOne(License::class);
    }

    public function addon_license()
    {
        return $this->license()->byType(License::ADDON_TYPE);
    }

    public function execution_license()
    {
        return $this->license()->byType(License::EXECUTION_TYPE);
    }

    public function final_reports()
    {
        return $this->hasMany(FinalReport::class);
    }

    public function final_report()
    {
        return $this->hasOne(FinalReport::class);
    }

    public function specialties_file()
    {
        return $this->hasMany(OrderSpecilatiesFiles::class, 'order_id');
    }

    public function service()
    {
        return $this->belongsToMany(Service::class, 'order_service', 'order_id', 'service_id')
                    ->withPivot('service_id', 'order_id', 'unit');
    }

    public function obligations()
    {
        return $this->hasMany(OrderSpecialtyObligation::class);
    }

    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    public function service_provider()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }

    public function consulting()
    {
        return $this->belongsTo(User::class, 'consulting_office_id');
    }

    public function contractor_report()
    {
        return $this->hasMany(ContractorReport::class, 'order_id');
    }

    public function scopeWhereContractor($q, $contractor_id)
    {
        return $q->where('contractor_id', $contractor_id);
    }

    public function file()
    {
        return $this->hasMany(OrderFile::class);
    }

    public function logs()
    {
        return $this->hasMany(OrderLogs::class);
    }

    public function contractorReport()
    {
        return $this->hasMany(ContractorReport::class, 'order_id');
    }

    public function deliverRejectReson()
    {
        return $this->hasMany(DeliverRejectReson::class, 'order_id');
    }

    public function orderSharerRegected()
    {
        return $this->orderSharer()->where('status', OrderSharer::REJECT);
    }

    public function orderSharer()
    {
        return $this->hasMany(OrderSharer::class, 'order_id');
    }

    public function orderSharerAccepts()
    {
        return $this->hasManyThrough(
            OrderSharerAccept::class,
            OrderSharer::class,
            'order_id',        // Foreign key on the environments table...
            'order_sharer_id', // Foreign key on the deployments table...
            'id',              // Local key on the projects table...
            'id'               // Local key on the environments table...
        );
    }

    public function orderSharerRejects()
    {
        return $this->hasManyThrough(
            OrderSharerReject::class,
            OrderSharer::class,
            'order_id', // Foreign key on the environments table...
            'order_sharer_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }

    public function scopeWhereDesigner($query, $designer_id)
    {
        return $query->where('designer_id', $designer_id);
    }

    public function scopeWhereServiceProvider($query, $service_provider_id)
    {
        return $query->where('owner_id', $service_provider_id);
    }

    public function scopeByStatus(Builder $query, $status)
    {
        return $query->whereIn('status', (array) $status);
    }

    public function getOrderStatusAttribute()
    {
        $orderStatus = static::getOrderStatuses();
        $status = null;

        if( isset($orderStatus[ $this->status ]) ) {
            $status = $orderStatus[ $this->status ];
            if( $this->status === static::FINAL_REPORT_ATTACHED ) {
                $hasConsultingOfficeFinalReportPath = $this->hasConsultingOfficeFinalReportPath() && !$this->hasConsultingOfficeFinalReportNote();
                $hasContractorFinalReportPath = $this->hasContractorFinalReportPath() && !$this->hasContractorFinalReportNote();

                if( $hasContractorFinalReportPath && $hasConsultingOfficeFinalReportPath ) {
                    $status = __("models/order.final_report_attached_status.ready");
                } elseif( $hasConsultingOfficeFinalReportPath ) {
                    $status = __("models/order.final_report_attached_status.contractor");
                } elseif( $hasContractorFinalReportPath ) {
                    $status = __("models/order.final_report_attached_status.consulting_office");
                } else {
                    $status = __("models/order.final_report_attached_status.new");
                }
            }
        }

        return $status;
    }

    public static function getOrderStatuses(): array
    {
        return [
            static::PENDING => 'معلق',
            static::REQUEST_BEGIN_CREATED => 'قيد إنشاء الطلب',
            static::DESIGN_REVIEW => 'مراجعة التصاميم',
            static::DESIGN_APPROVED => 'معتمد التصاميم',
            static::DESIGN_AWAITING_GOV_APPROVE => 'بانتظار اعتماد الجهات الحكومية',
            static::PROCESSING => 'الطلب تحت الإجراء',
            static::COMPLETED => 'الطلب مكتمل',
            static::PENDING_LICENSE_ISSUED => 'بانتظار إصدار الرخصة',
            static::ORDER_APPROVED => 'تمت الموافقة النهائية',
            static::PENDING_OPERATION => 'تم اصدار رخصة الإضافات',
            static::FINAL_REPORT_ATTACHED => 'تم ارفاق التقرير النهائي',
            static::FINAL_REPORT_APPROVED => 'تم اعتماد التقارير النهائية',
            static::FINAL_LICENSE_GENERATED => 'تم إصدار رخصة الجاهزية',
        ];
    }

    public function lastDesignerNote()
    {
        return $this->hasOne(DeliverRejectReson::class)->orderByDesc('created_at')->take(1);
    }

    public function consulting_orders()
    {
        return $this->hasMany(ConsultingOrders::class, 'order_id');
    }

    public function is_accepted($user)
    {
        return $this->consulting_orders->where('user_id', isModel($user) ? $user->id : $user)->count();
    }

    //////////////////
    /// filters     //
    /// //////////////

    public function scopeWhereOrderId($q, $order_id)
    {

        return $q->when($order_id, function($q) use ($order_id) {
            $q->where('id', $order_id);
        });
    }

    public function scopeWhereDesignerId($q, $designer_id)
    {

        return $q->when($designer_id, function($q) use ($designer_id) {
            $q->where('designer_id', $designer_id);
        });
    }

    public function scopeWhereConsultingId($q, $consulting_id)
    {

        return $q->when($consulting_id, function($q) use ($consulting_id) {
            $q->where('consulting_office_id', $consulting_id);
        });
    }

    public function scopeWhereContractorId($q, $contractor_id)
    {

        return $q->when($contractor_id, function($q) use ($contractor_id) {
            $q->where('contractor_id', $contractor_id);
        });
    }

    public function scopeWhereDate($q, $from_date, $to_date)
    {

        return $q->when($from_date && $to_date, function($q) use ($from_date, $to_date) {
            $q->whereBetween('date', [ $from_date, $to_date ]);
        });
    }

    public function scopeWhereServiceProviderId($q, $service_provider_id)
    {

        return $q->when($service_provider_id, function($q) use ($service_provider_id) {
            $q->where('owner_id', $service_provider_id);
        });
    }

    public function licenseNeededForServiceProvider(): bool
    {

        return $this->status === static::PENDING_OPERATION && $this->hasLicense() &&
            $this->is_accepted($this->contractor_id) && $this->is_accepted($this->consulting_office_id);
    }

    public function licenseNeededForDelivery(): bool
    {
        return $this->isDesignApproved() && !$this->hasLicense();
    }

    public function hasLicense(): bool
    {
        return $this->license()->whereNotNull('created_at')->count();
    }

    public function getLicenseOrCreate(array $attributes = [])
    {
        $attributes[ 'created_at' ] ??= null;
        $license = $this->license()->firstOrNew([], $attributes);

        if( !$license->exists ) {
            $license->forceFill([ 'created_at' => data_get($attributes, 'created_at') ])
                    ->save();

            return $license->refresh();
        }

        return $license;
    }

    public function saveLicense(array $attributes = [])
    {
        $license = $this->getLicenseOrCreate([ 'order_id' => $this->id ]);
        $created_at = ($attributes[ 'created_at' ] ??= data_get($attributes, 'created_at', $license->created_at ?: now()));
        $attributes[ 'date' ] = data_get($attributes, 'date', $created_at ? ($license->date ?: now()) : null);
        if( $raft_company_box = $this->service_provider->getRaftCompanyBox() ) {
            $attributes[ 'box_raft_company_box_id' ] = data_get($raft_company_box, 'id');
            $attributes[ 'camp_raft_company_box_id' ] = data_get($raft_company_box, 'id');
        }

        $license->fill($attributes)
                ->forceFill(compact('created_at'))
                ->save();

        return $license->refresh();
    }

    public function hasFinalReport(): bool
    {
        return $this->final_report()->count();
    }

    /**
     * @param array $attributes
     *
     * @return \App\Models\FinalReport
     */
    public function getFinalReportOrCreate(array $attributes = [])
    {
        $final_report = $this->final_report()->firstOrNew([ 'order_id' => $this->id ?? -1 ], $attributes);

        if( !$final_report->exists ) {
            $final_report->save();

            return $final_report->refresh();
        }

        return $final_report;
    }

    public function saveFinalReport(array $attributes = [])
    {
        $final_report = $this->getFinalReportOrCreate([ 'order_id' => $this->id ]);

        $final_report
            ->fill($attributes)
            ->save();

        return $final_report->refresh();
    }

    public function isDesignApproved()
    {
        return $this->status === static::ORDER_APPROVED;
    }

    public function isPendingOperation()
    {
        return $this->status === static::PENDING_OPERATION;
    }

    public static function getRules(?string $constant = null)
    {
        $constant = str_ireplace('$', '', $constant ?: '$RULES');
        $rules = [];
        $_rules = static::$$constant ?? static::$RULES;

        foreach( $_rules as $column => $_rules ) {
            $rules[ $column ] = [];
            if( in_array('required', $_rules) ) {
                $rules[ $column ][ 'required' ] = true;
            }
            if( in_array('nullable', $_rules) ) {
                $rules[ $column ][ 'required' ] = false;
            }
        }

        return $rules;
    }

    public function hasContractorFinalReportNote(): bool
    {
        return (bool) $this->getContractorFinalReportNote();
    }

    public function hasConsultingOfficeFinalReportNote(): bool
    {
        return (bool) $this->getConsultingOfficeFinalReportNote();
    }

    public function getContractorFinalReportNote($default = null): ?string
    {
        return $this->final_report()->value('contractor_final_report_note') ?? value($default);
    }

    public function getConsultingOfficeFinalReportNote($default = null): ?string
    {
        return $this->final_report()->value('consulting_office_final_report_note') ?? value($default);
    }

    public function isConsultingOfficeFinalReportApproved(): bool
    {
        return (bool) $this->final_report()->value('consulting_office_final_report_approved');
    }

    public function isContractorFinalReportApproved(): bool
    {
        return (bool) $this->final_report()->value('contractor_final_report_approved');
    }

    public function isFinalReportFullyApproved(): bool
    {
        return $this->isContractorFinalReportApproved() && $this->isConsultingOfficeFinalReportApproved();
    }

    public function hasConsultingOfficeFinalReportPath(): bool
    {
        return (bool) $this->final_report()->value('consulting_office_final_report_path');
    }

    public function hasContractorFinalReportPath(): bool
    {
        return (bool) $this->final_report()->value('contractor_final_report_path');
    }

    public function shouldPostFinalReports()
    {
        return in_array($this->status, [ static::PENDING_OPERATION, static::FINAL_REPORT_ATTACHED ]);
    }

    public function userCanAttachFinalReport($user = null)
    {
        $user ??= currentUser();
        if( $user && !isModel($user) ) {
            $user = User::find($user);
        }

        $user ??= optional($user);
        $user_type = $user->isContractor() ? 'contractor' : (
        $user->isConsultngOffice() ? 'consulting_office' : ""
        );
        if( !$user_type ) {
            if( $user->id === $this->contractor_id ) {
                $user_type = 'contractor';
            } elseif( $user->id === $this->consulting_office_id ) {
                $user_type = 'consulting_office';
            }
        }

        if( !$user_type ) {
            return false;
        }

        $path_column = "{$user_type}_final_report_path";

        $final_report = optional($this->final_report());

        return (
                blank($final_report->value($path_column)) &&
                !$final_report->value("{$user_type}_final_report_approved")
            )
            ||
            (
            filled($final_report->value("{$user_type}_final_report_note"))
            );
    }

    public function shouldUserPostFinalReports()
    {
        return (
            in_array(currentUser()->type, [ User::CONTRACTOR_TYPE, User::CONSULTNG_OFFICE_TYPE ]) ||
            in_array(currentUser()->id, [ $this->contractor_id, $this->consulting_office_id ])
        );
    }

//    public function raft_company(){
//        return $this->service_provider()->belongsTo(User::class,'parent_id','id');
//    }

    public function isDesignReviewStatus(): bool
    {
        return $this->status == static::DESIGN_REVIEW;
    }

    public function scopeTaslemDashboardOrders(Builder $builder)
    {
        return $builder->where('status', static::DESIGN_REVIEW)->doesntHave('orderSharerRejects')->doesntHave('orderSharerAccepts')->doesntHave('deliverRejectReson');
    }

    public function isNewForTaslem(): bool
    {
        return $this->isDesignReviewStatus() && !$this->orderSharerRejects()->exists() && !$this->orderSharerAccepts()->exists() && !$this->deliverRejectReson()->exists();
    }

    public function hasDesignerWarning(): bool
    {
        return $this->isDesignReviewStatus() && ($this->lastDesignerNote()->where('status', 0)->exists() || ($this->orderSharerRegected()->exists() && $this->delivery_notes == 1));
    }

    public function isBackFromWarning(): bool
    {
        return ($this->isDesignReviewStatus() && !$this->delivery_notes && !$this->lastDesignerNote()->where('status', 0)->exists());
        //&&( (!$this->lastDesignerNote()->exists() && $this->orderSharerRegected()->exists()) || $this->lastDesignerNote()->where('status', 1)->exists()&&!$this->delivery_notes );
    }

    /**
     * @param int   $type
     * @param int   $limit
     * @param array $pdf_options
     *
     * @return \Barryvdh\Snappy\PdfWrapper
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function loadSnappyLicense(
        int $type = 1,
        int $limit = 8,
        array $pdf_options = [
            'page-size' => 'a4',
            'orientation' => 'portrait',
            'margin-bottom' => 0,
            'enable-forms' => true,
            'encoding' => 'utf-8',
            'enable-external-links' => true,
        ]
    ) {
        /** @var \Barryvdh\Snappy\Facades\SnappyPdf $pdf */
        $pdf = app()->make('snappy.pdf.wrapper');
        $service = order_services($this->id);
        $servicesLimit = ($service_count = $service->count()) > $limit ? $limit : $service_count;
        $half = ceil($servicesLimit / 2);
        $chunks = $service->chunk($half);
        $license = $this->license;
        $view = $type === 1 ? 'CP.licenses.print' : 'CP.licenses.print_execution_license';

        return $pdf->loadView($view, [
            'mode' => 'print',
            'mode_form' => 'print',
            'model' => $license,
            'print' => (bool) request()->get('print', true),
            'first_services' => $chunks[ 0 ] ?? [],
            'second_services' => $chunks[ 1 ] ?? [],
        ])
                   ->setOptions($pdf_options);
    }

    /**
     * @param int  $type
     * @param bool $full_path
     *
     * @return string|null
     */
    public function getLicenseFilename(int $type = 1, bool $full_path = false): ?string
    {
        $license_paths = $this->license_paths ?: [];
        $filename = $license_paths[ $type ] ?? '';

        return $full_path ? static::diskPath($filename) : $filename;
    }

    /**
     * @param string|null $filename
     * @param int         $type
     * @param int         $limit
     * @param bool        $save
     * @param bool        $overwrite overwrite license file if exists
     * @param array       $pdf_options
     *
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function generateLicenseFile(
        ?string &$filename = null,
        int $type = 1,
        bool $save = true,
        bool $overwrite = false,
        int $limit = 8,
        array $pdf_options = [
            'page-size' => 'a4',
            'orientation' => 'portrait',
            'margin-bottom' => 0,
            'enable-forms' => true,
            'encoding' => 'utf-8',
            'enable-external-links' => true,
        ]
    ) {
        $license = $this->license;
        $disk = static::disk();
        $filename ??= "License-{$license->id}-{$type}.pdf";

        $license_paths = $this->license_paths ?: [];
        $license_paths[ $type ] ??= '';
        $license_path = &$license_paths[ $type ];

        if( $license_path && !$save ) {
            $filename = $license_path;

            return $disk->get(($filename));
        }

        $pdf = $this->loadSnappyLicense($type, $limit, $pdf_options);

        $pdfShouldBeSaved = false;
        $oldFileExists = $disk->exists(($filename));
        if( $save ) {
            if( $typeExist = ($type === 1 || $license->type === 2) ) {
                $license_path = $filename;
                $this->license_paths = $license_paths;
            }

            if( $pdfShouldBeSaved = ($typeExist && ( !$oldFileExists || ($oldFileExists && $overwrite))) ) {
                $pdf->save($disk->path($filename), $overwrite);
            }

            $this->isDirty() && $this->save();
        }

        return $pdfShouldBeSaved || $oldFileExists ? $disk->get(($filename)) : $pdf->output();
    }

    /**
     * @param string|null $filename
     * @param int         $type
     * @param int         $limit
     * @param bool        $save
     * @param bool        $overwrite overwrite license file if exists
     * @param array       $pdf_options
     *
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function regenerateLicenseFile(
        ?string &$filename = null,
        int $type = 1,
        bool $save = true,
        int $limit = 8,
        array $pdf_options = [
            'page-size' => 'a4',
            'orientation' => 'portrait',
            'margin-bottom' => 0,
            'enable-forms' => true,
            'encoding' => 'utf-8',
            'enable-external-links' => true,
        ],
        bool $overwrite = true
    ) {
        return $this->generateLicenseFile($filename, $type, $save, $overwrite, $limit, $pdf_options);
    }

    /**
     * Returns response to show the license
     *
     * @param int         $type
     * @param string|null $filename
     *
     * @return \Illuminate\Http\Response
     */
    public function licenseResponse(int $type = 1, ?string $filename = null): \Illuminate\Http\Response
    {
        $filename = $this->getLicenseFilename($type);
        $content = $filename ? static::disk()->get($filename) : '';

        return new \Illuminate\Http\Response($content ?? '', 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function userCanAddReport(): bool
    {
        return intval($this->status) < intval(static::FINAL_REPORT_APPROVED);
    }

    public function notifyChanges($changes, bool $add_order_identifier = true)
    {
        $NotificationText = $changes . ($add_order_identifier ? ' لطلب  #' . $this->identifier : '');
        $this->saveLog($changes);
        optional($this->service_provider)->notify(new OrderNotification($NotificationText, $user_id = currentUserId()));

        $getTasleemUsers = \App\Models\User::where('type', 'Delivery')->get();
        foreach( $getTasleemUsers as $taslemUser ) {
            optional($taslemUser)->notify(new OrderNotification($NotificationText, $user_id));
        }

        return $this;
    }

    /**
     * Save order logs using translations.
     *
     * @param \Closure|string $text
     * @param int|null        $user_id
     *
     * @return self
     */
    public function saveLog($text, $user_id = null): self
    {
        $_text = static::trans("logs." . value($text));
        $text = $_text === "logs.{$text}" ? static::trans($text) : $_text;
        save_logs($this, $user_id ?? currentUserId(), $text);

        return $this;
    }

    /**
     * @param bool $save
     *
     * @return self
     */
    public function agree(bool $save = true): self
    {
        $this->getLicenseOrCreate()
             ->fill([
                        'type' => License::EXECUTION_TYPE,
                    ])
             ->save();

        $this->agreed = true;
        $this->status = Order::FINAL_LICENSE_GENERATED;

        if( $save ) {
            $this->save();
            $this->generateLicenseFile($filename, License::EXECUTION_TYPE, true, true);

            return $this->refresh();
        }

        return $this;
    }
}
