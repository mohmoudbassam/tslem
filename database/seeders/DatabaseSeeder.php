<?php

namespace Database\Seeders;

use App\Models\ConstParnet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           BeneficiresCoulumnsSeeder::class
        ]);
        \App\Models\User::query()->create([
          'name'=>'admin',
            'password'=>123456,
            'email'=>'test@test.com',
            'type'=>'admin'
        ]);
        \App\Models\User::query()->create([
          'name'=>'service',
            'password'=>123456,
            'email'=>'service@test.com',
            'type'=>'service_provider'
        ]);
        \App\Models\User::query()->create([
          'name'=>'designer',
            'password'=>123456,
            'email'=>'designer@test.com',
            'type'=>'design_office'
        ]);  \App\Models\User::query()->create([
          'name'=>'designer2',
            'password'=>123456,
            'email'=>'designer2@test.com',
            'type'=>'design_office'
        ]);

        ConstParnet::create([
            'name' => 'قائمة طبقات GIS للمخيمات من وزارة الحج والعمرة'
        ]);


    }
}
