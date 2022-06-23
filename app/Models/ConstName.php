<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstName extends Model
{
    use HasFactory;
    protected $table = 'const_name';

    protected $fillable = ['name', 'parnet_id'];
}
