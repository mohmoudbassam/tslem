<?php

namespace Database\Seeders;

use App\Models\ServiceFileType;
use Illuminate\Database\Seeder;

class ServiceFileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceFileType::query()->create([
           'name_ar'=>'خريطة',
           'name_en'=>'map'
        ]);
        ServiceFileType::query()->create([
           'name_ar'=>'خريطة',
           'name_en'=>'load'
        ]);
        ServiceFileType::query()->create([
           'name_ar'=>'حسابات إنشائية',
           'name_en'=>'construction_accounts'
        ]); ServiceFileType::query()->create([
           'name_ar'=>'حسابات كهربائية',
           'name_en'=>'ele'
        ]);
    }
}
