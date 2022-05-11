<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded=[];

    public const AWAITING_DESIGN_OFFICE_APPROVAL =1;
    public const DESIGN_REVIEW =2;
    public const UNDERWAY =3;
    public const DELIVERED =4;
    public const APPROVED =5;
    public const PENDING =6;

    public function designer(){
        return $this->belongsTo(User::class,'designer_id');
    }
    public function service_provider(){
        return $this->belongsTo(User::class,'owner_id');
    }
    public function file(){
        return $this->hasMany(OrderFile::class);
    }
    public function logs(){
        return $this->hasMany(OrderLogs::class);
    }

    public function scopeWhereDesigner($query,$designer_id){
        return $query->where('designer_id',$designer_id);
    }
//    public function scopeWhereDelivery($query,$delivery_id){
//        return $query->where('designer_id',$delivery_id);
//    }
    public function scopeWhereServiceProvider($query,$service_provider_id){
        return $query->where('owner_id',$service_provider_id);
    }

    public function getOrderStatusAttribute(){
        return[
            '1'=>'بانتظار موافقة مكتب التصميم',
            '2'=>'مراجعة التصاميم',
            '3'=>'قيد التنفيذ',
            '4'=>'تم التسليم',
            '5'=>'تم الاعتماد',
            '6'=>'معلق'
        ][$this->status];
    }

}
