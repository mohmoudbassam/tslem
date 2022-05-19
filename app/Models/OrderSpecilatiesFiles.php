<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSpecilatiesFiles extends Model
{
    use HasFactory;

    protected $table='order_specialties_files';
    protected $guarded=[];


    public function specialties(){
       return  $this->belongsTo(Specialties::class,'specialties_id');
    }

}
