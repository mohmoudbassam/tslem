<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];


    public const PENDING = 1;
    public const REQUEST_BEGIN_CREATED  = 2;
    public const DESIGN_REVIEW = 3;
    public const DESIGN_APPROVED =4;
    public const PROCESSING =5;
    public const COMPLETED =6;



    public function specialties_file(){
        return $this->hasMany(OrderSpecilatiesFiles::class,'order_id');
    }

    public function service(){
      return  $this->belongsToMany(Service::class,'order_service','order_id','service_id')
         ->withPivot('service_id', 'order_id','unit');
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
        return $this->hasMany(ContractorReport::class,'order_id');
    }

    public function deliverRejectReson() {
        return $this->hasMany(DeliverRejectReson::class, 'order_id');
    }

    public function orderSharer() {
        return $this->hasMany(OrderSharer::class, 'order_id');
    }

    public function orderSharerAccepts() {
        return $this->hasManyThrough(
            OrderSharerAccept::class,
            OrderSharer::class,
            'order_id', // Foreign key on the environments table...
            'order_sharer_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }

    public function orderSharerRejects() {
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
            '4' => 'معتمد التصماميم'

        ][$this->status];
    }

    public function lastDesignerNote(){
        return $this->hasOne(DeliverRejectReson::class)->orderByDesc('created_at')->take(1);
    }

    public function consulting_or_constroctor(){
        return $this->hasMany(ConsultingOrders::class, 'order_id');
    }

    public function is_accepted($user){

        return $this->consulting_or_constroctor->where('user_id',$user->id)->count();
    }

}
