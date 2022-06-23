<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorSpecialtiesPivot extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table='contractor_specialties_pivot';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialty()
    {
        return $this->belongsTo(ContractorSpecialties::class, "specialties_id");
    }
}
