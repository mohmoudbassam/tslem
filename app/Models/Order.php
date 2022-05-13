<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded=[];


    public const DESIGN_REVIEW =1;
    public const ORDER_REVIEW =2;
    public const DESIGN_APPROVED =3;
    public const DONE =4;
    public const APPROVED =5;


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

    public function scopeWhereServiceProvider($query,$service_provider_id){
        return $query->where('owner_id',$service_provider_id);
    }

    public function getOrderStatusAttribute(){
        return[
            '1'=>'مراجعة التصاميم',
            '2'=>'مراجعة الطلب',
            '3'=>'تم اعتماد التصاميم',
            '4'=>'تم التنفيذ',
            '5'=>'تم الإعتماد'
        ][$this->status];
    }

}
