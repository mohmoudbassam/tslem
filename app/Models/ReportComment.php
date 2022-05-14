<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportComment extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table='report_comment';

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function report(){
        return $this->belongsTo(ContractorReport::class,'report_id');
    }

}
