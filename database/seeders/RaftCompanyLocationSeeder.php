<?php

namespace Database\Seeders;

use App\Models\RaftCompanyLocation;
use Illuminate\Database\Seeder;

class RaftCompanyLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RaftCompanyLocation::query()->create([
            'name' => 'جنوب شرق اسيا'
        ]);
        RaftCompanyLocation::query()->create([
            'name' => 'جنوب اسيا'
        ]);
        RaftCompanyLocation::query()->create([
            'name' => 'افريقيا غير العربية'
        ]);
        RaftCompanyLocation::query()->create([
            'name' => 'الدول العربية'
        ]);
        RaftCompanyLocation::query()->create([
            'name' => 'تركيا'
        ]);
        RaftCompanyLocation::query()->create([
            'name' => 'ايران'
        ]);
    }
}
