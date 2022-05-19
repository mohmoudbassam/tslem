<?php

namespace Database\Seeders;

use App\Models\Service;

use App\Models\Specialties;
use Illuminate\Database\Seeder;

class ArchitectServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $architect = Specialties::query()->create([
            'name_ar' => 'المعماري',
            'name_en' => 'architect'
        ]);

        $first = Service::query()->create([
            'name' => 'أبواب للخيام',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);

        $second = Service::query()->create([
            'name' => 'أعمال إنشائية جمالية',
            'specialties_id' => $architect->id,
            'unit' => 'المساحة / م2'
        ]);

        $third = Service::query()->create([
            'name' => 'تضليل المدحل والممرات',
            'specialties_id' => $architect->id,
            'unit' => 'المساحة / م2'
        ]);

        $fourth = Service::query()->create([
            'name' => 'تغطية المدخل والأرضيات',
            'specialties_id' => $architect->id,
            'unit' => 'المساحة / م2'
        ]);

        $fifth = Service::query()->create([
            'name' => 'إضافة مصلى',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);

        $sixth = Service::query()->create([
            'name' => 'إضافة حوائط جبسية',
            'specialties_id' => $architect->id,
            'unit' => 'م2'
        ]);

        $seven = Service::query()->create([
            'name' => 'إضافة أسقف جبسية',
            'specialties_id' => $architect->id,
            'unit' => 'م2'
        ]);

        $eght = Service::query()->create([
            'name' => 'إضافة أرضيات',
            'specialties_id' => $architect->id,
            'unit' => 'المساحة / م2'
        ]);

        $nine = Service::query()->create([
            'name' => 'إضافة دورات مياه',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);

        $ten = Service::query()->create([
            'name' => 'إضافة  سواتر',
            'specialties_id' => $architect->id,
            'unit' => 'المساحة / م2'
        ]);

        $eleven = Service::query()->create([
            'name' => 'إضافة  مضلات (حماية من الشمس)',
            'specialties_id' => $architect->id,
            'unit' => 'المساحة / م2'
        ]);

        $twilv = Service::query()->create([
            'name' => 'حماية نفايات للممرات',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);

        $thrteen = Service::query()->create([
            'name' => 'تشجير المخيم / تزين',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);

        $foutheen = Service::query()->create([
            'name' => 'أرفف للحجاج',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);

        $fifteen = Service::query()->create([
            'name' => 'عيادات إسعافات اولية',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);

        $sixteen = Service::query()->create([
            'name' => 'دواليب حقائب وأحذية',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);

        $seventeen = Service::query()->create([
            'name' => 'اخرى',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);

    }

}
