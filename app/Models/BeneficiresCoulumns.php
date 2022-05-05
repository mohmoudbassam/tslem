<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiresCoulumns extends Model
{
    use HasFactory;

    protected $table='beneficiaries_columns';
    protected $guarded=[];
    public $timestamps=false;
}
