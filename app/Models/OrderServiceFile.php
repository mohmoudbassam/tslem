<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderServiceFile extends Model
{
    use HasFactory;

    protected $table = 'order_service_file';
    protected $guarded = [];

    public function file_type()
    {
        return $this->belongsTo(ServiceFileType::class, 'type');
    }
//
//    public function getPathAttribute($file)
//    {
//        if ($file) {
//
//            return asset('storage/' . $file);
//        } else {
//            return asset('storage/profiles/profile_placeholder.jpg');
//        }
//    }
}
