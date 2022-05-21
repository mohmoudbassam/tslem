<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSharer extends Model
{
    use HasFactory;

    protected $table = "order_sharers";

    protected $guarded = [];

    public function rejects() {
        return $this->hasMany(OrderSharerReject::class, "order_sharer_id");
    }

    public function accepts() {
        return $this->hasMany(OrderSharerAccept::class, "order_sharer_id");
    }

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
