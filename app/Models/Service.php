<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service_specialties';

    public function file_type()
    {
        return $this->belongsToMany(ServiceFileType::class, 'service_file', 'service_id', 'file_id');
    }

    public function specialties(){
        return $this->belongsTo(Specialties::class, 'specialties_id');
    }

}
