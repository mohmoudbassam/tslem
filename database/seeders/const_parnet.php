<?php

namespace Database\Seeders;

use App\Models\ConstName;
use App\Models\ConstParnet;
use Illuminate\Database\Seeder;

class const_parnet extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConstParnet::create([
            'name' => 'قائمة طبقات GIS للمخيمات من وزارة الحج والعمرة'
        ]);
    }
}
