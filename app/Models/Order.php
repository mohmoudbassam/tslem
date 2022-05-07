<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded=[];


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

    public function scopewhereDesigner($query,$designer_id){
        return $query->where('designer_id',$designer_id);
    }
    public function scopewhereServiceProvider($query,$service_provider_id){
        return $query->where('owner_id',$service_provider_id);
    }
}
