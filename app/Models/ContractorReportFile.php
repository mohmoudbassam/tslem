<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorReportFile extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'contractor_report_files';

    public function report()
    {
        return $this->belongsTo(ContractorReport::class);
    }


    function getPathAttribute($path)
    {
        return asset('storage/' . $path);
    }

}
