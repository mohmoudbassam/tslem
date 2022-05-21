<?php

namespace Database\Seeders;

use App\Models\ConstParnet;
use App\Models\Order;
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
            BeneficiresCoulumnsSeeder::class,
            ArchitectServiceSeeder::class,
            ElectricalServiceSeeder::class,
            ConstructionServiceSeeder::class,
            MechanicalServiceSeeder::class
        ]);
        \App\Models\User::query()->create([
            'name' => 'admin',
            'password' => 123456,
            'email' => 'test@test.com',
            'type' => 'admin'
        ]);
      $service_provider=  \App\Models\User::query()->create([
            'name' => 'service',
            'password' => 123456,
            'email' => 'service@test.com',
            'type' => 'service_provider',
            'company_name' => 'service_company',
            'verified' => 1
        ]);
        $designer=    \App\Models\User::query()->create([
            'name' => 'designer',
            'password' => 123456,
            'email' => 'designer@test.com',
            'type' => 'design_office',
            'company_name' => 'designer_company',
            'verified' => 1

        ]);
        \App\Models\User::query()->create([
            'name' => 'designer2',
            'password' => 123456,
            'email' => 'designer2@test.com',
            'type' => 'design_office',
            'company_name' => 'designer2_company',
            'verified' => 1
        ]);
        \App\Models\User::query()->create([
            'name' => 'taslem',
            'password' => 123456,
            'email' => 'taslem@test.com',
            'type' => 'Delivery',
            'company_name' => 'taslem_company',
            'verified' => 1
        ]);
        \App\Models\User::query()->create([
            'name' => 'contractor',
            'password' => 123456,
            'email' => 'contractor@test.com',
            'type' => 'contractor',
            'company_name' => 'contractor_company',
            'verified' => 1
        ]);
        \App\Models\User::query()->create([
            'name' => 'consulting_office',
            'password' => 123456,
            'email' => 'consulting_office@test.com',
            'type' => 'consulting_office',
            'company_name' => 'consulting_company',
            'verified' => 1
        ]);
        \App\Models\User::query()->create([
            'name' => 'gov',
            'password' => 123456,
            'email' => 'gov@test.com',
            'type' => 'Sharer',
            'company_name' => 'Sharer Company',
            'verified' => 1
        ]);
\App\Models\User::query()->create([
            'name' => 'gov1',
            'password' => 123456,
            'email' => 'gov1@test.com',
            'type' => 'Sharer',
            'company_name' => 'Sharer1 Company',
            'verified' => 1
        ]);
\App\Models\User::query()->create([
            'name' => 'gov2',
            'password' => 123456,
            'email' => 'gov2@test.com',
            'type' => 'Sharer',
            'company_name' => 'Sharer2 Company',
            'verified' => 1
        ]);
\App\Models\User::query()->create([
            'name' => 'gov3',
            'password' => 123456,
            'email' => 'gov3@test.com',
            'type' => 'Sharer',
            'company_name' => 'Sharer3 Company',
            'verified' => 1
        ]);

        ConstParnet::query()->create([
            'name' => 'قائمة طبقات GIS للمخيمات من وزارة الحج والعمرة'
        ]);

        Order::query()->create([
           'description'=>'test test' ,
            'title'=>'test',
            'owner_id'=>$service_provider->id,
            'designer_id'=>$designer->id,
            'date'=>now()->format('Y-m-d')
        ]);
    }
}
