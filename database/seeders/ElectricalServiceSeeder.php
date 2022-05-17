<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceFileType;
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
            'name_en' => 'electrical'
        ]);
        $file_type = ServiceFileType::query()->where('name_en', 'ele')->first();
        $map = ServiceFileType::query()->where('name_en', 'map')->first();
        $first = Service::query()->create([
            'name' => 'إضافة وحدات إنارة داخل الخيام',
            'specialties_id' => $electrical->id
        ]);
        $first->file_type()->attach($map);
        $first->file_type()->attach($file_type);
        $second = Service::query()->create([
            'name' => 'إضافة وحداة إنارة للممرات ',
            'specialties_id' => $electrical->id
        ]);
        $second->file_type()->attach($map);
        $second->file_type()->attach($file_type);
        $third = Service::query()->create([
            'name' => 'إضافة وحدات تكيف',
            'specialties_id' => $electrical->id
        ]);
        $third->file_type()->attach($map);
        $third->file_type()->attach($file_type);
        $fourth = Service::query()->create([
            'name' => 'إضافات سخانات مياه (غلايات)',
            'specialties_id' => $electrical->id
        ]);
        $fourth->file_type()->attach($map);
        $fourth->file_type()->attach($file_type);
        $fifth = Service::query()->create([
            'name' => 'إضافة كاميرات مراقبة للممرات',
            'specialties_id' => $electrical->id
        ]);
        $fifth->file_type()->attach($map);
        $fifth->file_type()->attach($file_type);
        $sixth = Service::query()->create([
            'name' => 'خدمات إنترنت و واي فاي',
            'specialties_id' => $electrical->id
        ]);
        $sixth->file_type()->attach($map);
        $sixth->file_type()->attach($file_type);
        $seventh = Service::query()->create([
            'name' => 'ثلاجات تبريد لعبوات مياه الشرب',
            'specialties_id' => $electrical->id
        ]);
        $seventh->file_type()->attach($map);
        $seventh->file_type()->attach($file_type);
        $eghit = Service::query()->create([
            'name' => 'ثلاجات الأيسكريم',
            'specialties_id' => $electrical->id
        ]);
        $eghit->file_type()->attach($map);
        $eghit->file_type()->attach($file_type);
        $ninth = Service::query()->create([
            'name' => 'أفياش الكهرباء',
            'specialties_id' => $electrical->id
        ]);
        $ninth->file_type()->attach($map);
        $ninth->file_type()->attach($file_type);
        $tenth = Service::query()->create([
            'name' => 'أجهزة صوتيات (سماعات)',
            'specialties_id' => $electrical->id
        ]);
        $tenth->file_type()->attach($map);
        $tenth->file_type()->attach($file_type);
        $elevent = Service::query()->create([
            'name' => 'مروحة كهربائية أرضية / عامودية لتهوية المداخل والممرات',
            'specialties_id' => $electrical->id
        ]);
        $elevent->file_type()->attach($map);
        $elevent->file_type()->attach($file_type);
       $twilv= Service::query()->create([
            'name' => 'مراوح رذاذ',
            'specialties_id' => $electrical->id
        ]);
        $twilv->file_type()->attach($map);
        $twilv->file_type()->attach($file_type);
      $thrteen=  Service::query()->create([
            'name' => 'لوح ارشادية',
            'specialties_id' => $electrical->id
        ]);
        $thrteen->file_type()->attach($map);
        $thrteen->file_type()->attach($file_type);
       $fourteen= Service::query()->create([
            'name' => 'اخري',
            'specialties_id' => $electrical->id
        ]);

        $fourteen->file_type()->attach($map);
        $fourteen->file_type()->attach($file_type);
    }
}
