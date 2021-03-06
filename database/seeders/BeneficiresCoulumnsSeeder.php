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
            'company_owner_id_photo' => '0'

        ]);
        BeneficiresCoulumns::query()->create([
            'type' => 'taslem_maintenance',
            'email' => '1',
            'phone' => '1',
            'company_owner_id_photo' => '0'
        ]);
        BeneficiresCoulumns::query()->create([
            'type' => 'Delivery',
            'responsible_name' => '1',
            'email' => '1',
            'phone' => '1',

        ]);
        BeneficiresCoulumns::query()->create([
            'type' => 'raft_company',
            'responsible_name' => '1',
            'email' => '1',
            'phone' => '1',
            'company_owner_id_photo' => '0'
        ]);
        BeneficiresCoulumns::query()->create([
            'type' => 'raft_center',

            'company_name' => '1',
            'company_owner_name' => '1',
            'email' => '1',
            'box_number' => '1',
            'camp_number' => '1',
            'phone' => '1',
            'employee_number' => '1',

        ]);
        BeneficiresCoulumns::query()->create([
            'type' => 'service_provider',
            'company_name' => '1',
            'company_owner_name' => '1',
            'commercial_record' => '1',
            'website' => '1',
            'license_number' => '1',
            'responsible_name' => '1',
            'id_number' => '1',
            'id_date' => '1',
            'source' => '1',
            'email' => '1',
            'phone' => '1',
            'commercial_file' => '1',
            'commercial_file_end_date' => '1',
            'address_file' => '0',
            'personalization_record' => '1',
            'hajj_service_license' => '1',
            'box_number' => 1,
            'camp_number' => 1,

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
            'telephone' => '0',
            'city' => '1',
            'employee_number' => '1',
            'commercial_file' => '1',
            'commercial_file_end_date' => '1',
            'rating_certificate' => '1',
            'rating_certificate_end_date' => '1',
            'address_file' => '1',
            'profession_license' => '1',
            'profession_license_end_date' => '1',
            'business_license' => '1',
            'business_license_end_date' => '1',
            'social_insurance_certificate' => '0',
            'social_insurance_certificate_end_date' => '1',
            'certificate_of_zakat' => '0',
            'date_of_zakat_end_date' => '0',
            'saudization_certificate' => '0',
            'saudization_certificate_end_date' => '0',
            'chamber_of_commerce_certificate' => '0',
            'chamber_of_commerce_certificate_end_date' => '0',
            'tax_registration_certificate' => '0',
            'wage_protection_certificate' => '0',
            'memorandum_of_association' => '0',
            'commissioner_photo' => 0,
            'company_owner_id_photo' => 1,
            'commissioner_id_photo' => 0,


        ]);
        BeneficiresCoulumns::query()->create([
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
            'commercial_file' => '1',
            'commercial_file_end_date' => '1',
            'rating_certificate' => '1',
            'rating_certificate_end_date' => '1',
            'address_file' => '1',
            'profession_license' => '1',
            'profession_license_end_date' => '1',
            'business_license' => '1',
            'business_license_end_date' => '1',
            'social_insurance_certificate' => '1',
            'social_insurance_certificate_end_date' => '1',
            'certificate_of_zakat' => '1',
            'date_of_zakat_end_date' => '1',
            'saudization_certificate' => '0',
            'saudization_certificate_end_date' => '0',
            'chamber_of_commerce_certificate' => '1',
            'chamber_of_commerce_certificate_end_date' => '1',
            'tax_registration_certificate' => '0',
            'wage_protection_certificate' => '0',
            'memorandum_of_association' => '0',
        ]);
        BeneficiresCoulumns::query()->create([
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
            'commercial_file' => '1',
            'commercial_file_end_date' => '1',
            'rating_certificate' => '1',
            'rating_certificate_end_date' => '1',
            'address_file' => '1',
            'profession_license' => '1',
            'profession_license_end_date' => '1',
            'business_license' => '1',
            'business_license_end_date' => '1',
            'social_insurance_certificate' => '1',
            'social_insurance_certificate_end_date' => '1',
            'certificate_of_zakat' => '1',
            'date_of_zakat_end_date' => '1',
            'saudization_certificate' => '1',
            'saudization_certificate_end_date' => '1',
            'chamber_of_commerce_certificate' => '1',
            'chamber_of_commerce_certificate_end_date' => '1',
            'tax_registration_certificate' => '1',
            'wage_protection_certificate' => '1',
            'memorandum_of_association' => '1',
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
            'commercial_file' => '1',
            'commercial_file_end_date' => '1',
            'rating_certificate' => '1',
            'rating_certificate_end_date' => '1',
            'address_file' => '1',
            'profession_license' => '0',
            'profession_license_end_date' => '0',
            'business_license' => '1',
            'business_license_end_date' => '1',
            'social_insurance_certificate' => '0',
            'social_insurance_certificate_end_date' => '1',
            'certificate_of_zakat' => '0',
            'date_of_zakat_end_date' => '0',
            'saudization_certificate' => '0',
            'saudization_certificate_end_date' => '0',
            'chamber_of_commerce_certificate' => '0',
            'chamber_of_commerce_certificate_end_date' => '0',
            'tax_registration_certificate' => '0',
            'wage_protection_certificate' => '0',
            'memorandum_of_association' => '0',
            'commissioner_photo' => 0,
            'company_owner_id_photo' => 1,
            'commissioner_id_photo' => 0,

        ]);

    }
}
