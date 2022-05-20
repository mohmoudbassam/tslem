<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignerRejected extends Model
{
    use HasFactory;

    protected $table='designer_rejected';
    protected $guarded=[];

    public function order(){
        return $this->belongsTo(Order::class,'designer_id');
    }
}
