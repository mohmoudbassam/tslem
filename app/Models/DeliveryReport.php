<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryReport extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function attchments() {
        return $this->hasMany(DeliveryReportAttchment::class, 'report_id');
    }
    public function order(){
        return $this->belongsTo(Order::class)->withDefault();
    }
}
