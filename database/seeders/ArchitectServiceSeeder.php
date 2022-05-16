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
            'name_en'=>'architect'
        ]);

        Service::query()->create([
            'name' => 'أبواب للخيام',
            'specialties_id' => $architect->id,
            'unit'=>'عدد'
        ]);
        Service::query()->create([
            'name' => 'أعمال إنشائية جمالية',
            'specialties_id' => $architect->id,
            'unit'=>'م2'
        ]);
        Service::query()->create([
            'name' => 'تضليل المدحل والممرات',
            'specialties_id' => $architect->id,
            'unit'=>'م2'
        ]);
        Service::query()->create([
            'name' => 'تغطية المدخل والأرضيات',
            'specialties_id' => $architect->id,
            'unit'=>'م2'
        ]);
        Service::query()->create([
            'name' => 'إضافة مصلى',
            'specialties_id' => $architect->id,
            'unit'=>'عدد'
        ]);
        Service::query()->create([
            'name' => 'إضافة حوائط جبسية',
            'specialties_id' => $architect->id,
            'unit'=>'م2'
        ]);
        Service::query()->create([
            'name' => 'إضافة أسقف جبسية',
            'specialties_id' => $architect->id,
            'unit'=>'م2'
        ]);
        Service::query()->create([
            'name' => 'إضافة أرضيات',
            'specialties_id' => $architect->id,
            'unit'=>'م2'
        ]);
        Service::query()->create([
            'name' => 'إضافة دورات مياه',
            'specialties_id' => $architect->id,
            'unit'=>'عدد'
        ]);
        Service::query()->create([
            'name' => 'إضافة  سواتر',
            'specialties_id' => $architect->id,
            'unit'=>'م2'
        ]);
        Service::query()->create([
            'name' => 'إضافة  مضلات (حماية من الشمس)',
            'specialties_id' => $architect->id,
            'unit'=>'م2'
        ]);
        Service::query()->create([
            'name' => 'حماية نفايات للممرات',
            'specialties_id' => $architect->id,
            'unit'=>'عدد'
        ]);
        Service::query()->create([
            'name' => 'تشجير المخيم / تزين',
            'specialties_id' => $architect->id,
            'unit'=>'عدد'
        ]);
        Service::query()->create([
            'name' => 'أرفف للحجاج',
            'specialties_id' => $architect->id,
            'unit'=>'عدد'
        ]);
        Service::query()->create([
            'name' => 'عيادات إسعافات اولية',
            'specialties_id' => $architect->id,
            'unit'=>'عدد'
        ]);
        Service::query()->create([
            'name' => 'دواليب حقائب وأحذية',
            'specialties_id' => $architect->id,
            'unit'=>'عدد'
        ]);
        Service::query()->create([
            'name' => 'اخرى',
            'specialties_id' => $architect->id,
            'unit'=>'عدد'
        ]);
    }

}
