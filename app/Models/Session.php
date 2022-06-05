<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function RaftCompanyLocation()
    {
        return $this->belongsTo('App\Models\RaftCompanyLocation');
    }


    public function RaftCompanyBox()
    {
        return $this->belongsTo(RaftCompanyBox::class, 'raft_company_box_id', 'id');

    }
    public function scopePublished($query)
    {
        return $query->where('is_published', '1');
    }

    public function scopeNotPublished($query)
    {
        return $query->where('is_published', '0');
    }

    public function scopeByLocation($query, $location)
    {
        return $query->whereIn('raft_company_location_id', (array) $location);
    }
}
