<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Specialties;
use Illuminate\Database\Seeder;

class ElectricalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $electrical = Specialties::query()->create([
            'name_ar' => 'الكهربائية',
            'name_en'=>'electrical'
        ]);
        Service::query()->create([
            'name' => 'إضافة وحدات إنارة داخل الخيام',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'إضافة وحداة إنارة للممرات ',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'إضافة وحدات تكيف',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'إضافات سخانات مياه (غلايات)',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'إضافة كاميرات مراقبة للممرات',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'خدمات إنترنت و واي فاي',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'ثلاجات تبريد لعبوات مياه الشرب',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'ثلاجات الأيسكريم',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'أفياش الكهرباء',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'أجهزة صوتيات (سماعات)',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'مروحة كهربائية أرضية / عامودية لتهوية المداخل والممرات',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'مراوح رذاذ',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'لوح ارشادية',
            'specialties_id' => $electrical->id
        ]);
        Service::query()->create([
            'name' => 'اخري',
            'specialties_id' => $electrical->id
        ]);


    }
}
