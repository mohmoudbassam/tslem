<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSharer extends Model
{
    use HasFactory;

    protected $table = "order_sharers";

    protected $guarded = [];

    public const REJECT = '2';
    public const ACCEPT = '1';
    public const PENDING = '0';

    public function rejects()
    {
        return $this->hasMany(OrderSharerReject::class, "order_sharer_id");
    }

    public function accepts()
    {
        return $this->hasMany(OrderSharerAccept::class, "order_sharer_id");
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lastnote()
    {
        return $this->hasOne(OrderSharerReject::class, 'order_sharer_id')->latest()->take(1);
    }



    public function getOrderSharerStatusAttribute()
    {
        return [
            '1' => 'تم القبول',
            '2' => 'تم الرفض',
            '0' => 'بإنتظار القبول'
        ][$this->status];
    }
}
