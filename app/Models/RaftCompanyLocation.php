<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaftCompanyLocation extends Model
{
    use HasFactory;

    protected $table='raft_company_location';
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class,'id','raft_company_type');
    }

    public function box(){
       return $this->hasMany(RaftCompanyBox::class,'raft_company_location_id');
    }
}
