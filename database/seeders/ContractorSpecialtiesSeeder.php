<?php

namespace Database\Seeders;

use App\Models\ContractorSpecialties;
use Illuminate\Database\Seeder;

class ContractorSpecialtiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractorSpecialties::query()->create([
           'name'=>'عام'
        ]);
        ContractorSpecialties::query()->create([
           'name'=>'الوقاية والحماية من الحرائق'
        ]);
    }
}
