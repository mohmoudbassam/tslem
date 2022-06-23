<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultingReport extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function attchment(){
        return $this->hasMany(ConsultingReportAttchment::class, 'report_id');
    }

    public function scopeWhereDate($q, $from_date ,$to_date)
    {

        return $q->when($from_date&&$to_date, function ($q) use ($from_date,$to_date) {
            $q->whereBetween('created_at',[$from_date,$to_date]);
        });
    }

    public function order(){
        return $this->belongsTo(Order::class)->withDefault();
    }
}
