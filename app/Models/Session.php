<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function RaftCompanyLocation() {
        return $this->belongsTo('App\Models\RaftCompanyLocation');
    }

    public function RaftCompanyBox() {
        return $this->belongsTo('App\Models\RaftCompanyBox');
    }

    public function scopePublished($query){
        return $query->where('is_published','1');
    }

    public function scopeNotPublished($query){
        return $query->where('is_published','0');
    }
}
