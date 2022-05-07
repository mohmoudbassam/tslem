<?php

namespace Database\Seeders;

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
            'password'=>bcrypt(123456),
            'email'=>'test@test.com',
            'type'=>'admin'
        ]);
        \App\Models\User::query()->create([
          'name'=>'service',
            'password'=>bcrypt(123456),
            'email'=>'service@test.com',
            'type'=>'service_provider'
        ]);
    }
}
