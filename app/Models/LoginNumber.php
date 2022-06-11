<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginNumber extends Model
{
    use HasFactory;

    protected $table = 'login_number';

    protected $guarded=[];

}
