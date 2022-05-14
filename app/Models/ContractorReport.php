<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorReport extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'contractor_report';

    public function files()
    {
        return $this->hasMany(ContractorReportFile::class, 'report_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(ReportComment::class, 'report_id', 'id');
    }

}
