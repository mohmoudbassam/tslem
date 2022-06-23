<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLogs extends Model
{
    use HasFactory;

    protected $table = 'order_logs';
    protected $guarded = [];

    public function order()
    {
        $this->belongsTo(Order::class);
    }
}
