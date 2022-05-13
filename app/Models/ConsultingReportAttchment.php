<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultingReportAttchment extends Model
{
    use HasFactory;

    protected $guarded = [];

    function getFilePathAttribute($path)
    {
        return asset('storage/' . $path);
    }
}
