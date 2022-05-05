<?php

namespace Database\Seeders;

use App\Models\BeneficiresCoulumns;
use Illuminate\Database\Seeder;

class BeneficiresCoulumnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BeneficiresCoulumns::query()->create([
            'type' => 'Kdana',
            'responsible_name' => '1',
            'email' => '1',
            'phone' => '1',
        ]);
        BeneficiresCoulumns::query()->create([
            'type' => 'Delivery',
            'responsible_name' => '1',
            'email' => '1',
            'phone' => '1',
        ]);
        BeneficiresCoulumns::query()->create([
            'type' => 'service_provider',
            'company_name' => '1',

            'company_owner_name' => '1',
            'commercial_record' => '1',
            'website' => '1',
            'responsible_name' => '1',
            'id_number' => '1',
            'id_date' => '1',
            'source' => '1',
            'email' => '1',
            'phone' => '1',

        ]);
        BeneficiresCoulumns::query()->create([
            'type' => 'design_office',
            'company_name' => '1',
            'company_type' => '1',
            'company_owner_name' => '1',
            'commercial_record' => '1',
            'website' => '1',
            'responsible_name' => '1',
            'id_number' => '1',
            'id_date' => '1',
            'source' => '1',
            'email' => '1',
            'phone' => '1',
            'address' => '1',
            'telephone' => '1',
            'city' => '1',
            'employee_number' => '1',
        ]);  BeneficiresCoulumns::query()->create([
            'type' => 'Sharer',
            'company_name' => '1',
            'company_type' => '1',
            'company_owner_name' => '1',
            'commercial_record' => '1',
            'website' => '1',
            'responsible_name' => '1',
            'id_number' => '1',
            'id_date' => '1',
            'source' => '1',
            'email' => '1',
            'phone' => '1',
            'address' => '1',
            'telephone' => '1',
            'city' => '1',
            'employee_number' => '1',
        ]); BeneficiresCoulumns::query()->create([
            'type' => 'consulting_office',
            'company_name' => '1',
            'company_type' => '1',
            'company_owner_name' => '1',
            'commercial_record' => '1',
            'website' => '1',
            'responsible_name' => '1',
            'id_number' => '1',
            'id_date' => '1',
            'source' => '1',
            'email' => '1',
            'phone' => '1',
            'address' => '1',
            'telephone' => '1',
            'city' => '1',
            'employee_number' => '1',
        ]);
BeneficiresCoulumns::query()->create([
            'type' => 'contractor',
            'company_name' => '1',
            'company_type' => '1',
            'company_owner_name' => '1',
            'commercial_record' => '1',
            'website' => '1',
            'responsible_name' => '1',
            'id_number' => '1',
            'id_date' => '1',
            'source' => '1',
            'email' => '1',
            'phone' => '1',
            'address' => '1',
            'telephone' => '1',
            'city' => '1',
            'employee_number' => '1',
        ]);

    }
}
