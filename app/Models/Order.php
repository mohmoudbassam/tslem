<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const PENDING = 1;
    public const REQUEST_BEGIN_CREATED = 2;
    public const DESIGN_REVIEW = 3;
    public const DESIGN_APPROVED = 4;
    public const PROCESSING = 5;
    public const COMPLETED = 6;
    public const PENDING_LICENSE_ISSUED = 7;

    public function license()
    {
        return $this->hasOne(License::class);
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

    public function orderSharer()
    {
        return $this->hasMany(OrderSharer::class, 'order_id');
    }

    public function orderSharerAccepts()
    {
        return $this->hasManyThrough(
            OrderSharerAccept::class,
            OrderSharer::class,
            'order_id', // Foreign key on the environments table...
            'order_sharer_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
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

    public function getOrderStatusAttribute()
    {
        return [
                   '1' => 'معلق',
                   '2' => 'قيد انشاء الطلب',
                   '3' => 'مراجعة التصاميم',
                   '4' => 'معتمد التصاميم',
                   '7' => 'بإنتظار اصدار الرخصة',

               ][ $this->status ];
    }

    public function lastDesignerNote()
    {
        return $this->hasOne(DeliverRejectReson::class)->orderByDesc('created_at')->take(1);
    }

    public function consulting_or_constroctor()
    {
        return $this->hasMany(ConsultingOrders::class, 'order_id');
    }

    public function is_accepted($user)
    {

        return $this->consulting_or_constroctor->where('user_id', $user->id)->count();
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

    public function licenseNeeded(): bool
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
        if( $raft_company_box = currentUser()->getRaftCompanyBox() ) {
            $attributes[ 'box_raft_company_box_id' ] = data_get($raft_company_box, 'id');
            $attributes[ 'camp_raft_company_box_id' ] = data_get($raft_company_box, 'id');
        }

        $license->fill($attributes)
                ->forceFill(compact('created_at'))
                ->save();

        return $license->refresh();
    }

    public function isDesignApproved()
    {
        return $this->status === static::DESIGN_APPROVED;
    }
}
