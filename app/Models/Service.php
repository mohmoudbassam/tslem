<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service_specialties';

    protected $guarded = [];


    public function specialties(){
        return $this->belongsTo(Specialties::class, 'specialties_id');
    }

}
