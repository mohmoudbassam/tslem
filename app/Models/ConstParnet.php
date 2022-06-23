<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstParnet extends Model
{
    use HasFactory;

    protected $table = 'const_parnet';
    protected $fillable = ['name'];
}
