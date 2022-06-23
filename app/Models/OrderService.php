<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    use HasFactory;

    protected $table='order_service';
    protected $guarded=[];


    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function order_service_file(){
        return $this->hasMany(OrderServiceFile::class,'order_service_id');
    }




}
