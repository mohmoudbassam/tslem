<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceFile;
use App\Models\ServiceFileType;
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
        $file_type = ServiceFileType::query()->where('name_en', 'map')->first();
        $first = Service::query()->create([
            'name' => 'أبواب للخيام',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);
        $first->file_type()->attach($file_type);

        $second = Service::query()->create([
            'name' => 'أعمال إنشائية جمالية',
            'specialties_id' => $architect->id,
            'unit' => 'م2'
        ]);
        $second->file_type()->attach($file_type);
        $third = Service::query()->create([
            'name' => 'تضليل المدحل والممرات',
            'specialties_id' => $architect->id,
            'unit' => 'م2'
        ]);
        $third->file_type()->attach($file_type);
        $fourth = Service::query()->create([
            'name' => 'تغطية المدخل والأرضيات',
            'specialties_id' => $architect->id,
            'unit' => 'م2'
        ]);
        $fourth->file_type()->attach($file_type);
        $fifth = Service::query()->create([
            'name' => 'إضافة مصلى',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);
        $fifth->file_type()->attach($file_type);
        $sixth = Service::query()->create([
            'name' => 'إضافة حوائط جبسية',
            'specialties_id' => $architect->id,
            'unit' => 'م2'
        ]);
        $sixth->file_type()->attach($file_type);
        $seven = Service::query()->create([
            'name' => 'إضافة أسقف جبسية',
            'specialties_id' => $architect->id,
            'unit' => 'م2'
        ]);
        $seven->file_type()->attach($file_type);
        $eght = Service::query()->create([
            'name' => 'إضافة أرضيات',
            'specialties_id' => $architect->id,
            'unit' => 'م2'
        ]);
        $eght->file_type()->attach($file_type);
        $nine = Service::query()->create([
            'name' => 'إضافة دورات مياه',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);
        $nine->file_type()->attach($file_type);
        $ten = Service::query()->create([
            'name' => 'إضافة  سواتر',
            'specialties_id' => $architect->id,
            'unit' => 'م2'
        ]);
        $ten->file_type()->attach($file_type);
        $eleven = Service::query()->create([
            'name' => 'إضافة  مضلات (حماية من الشمس)',
            'specialties_id' => $architect->id,
            'unit' => 'م2'
        ]);
        $eleven->file_type()->attach($file_type);
        $twilv = Service::query()->create([
            'name' => 'حماية نفايات للممرات',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);
        $twilv->file_type()->attach($file_type);
        $thrteen = Service::query()->create([
            'name' => 'تشجير المخيم / تزين',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);
        $thrteen->file_type()->attach($file_type);
        $foutheen = Service::query()->create([
            'name' => 'أرفف للحجاج',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);
        $foutheen->file_type()->attach($file_type);
        $fifteen = Service::query()->create([
            'name' => 'عيادات إسعافات اولية',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);
        $fifteen->file_type()->attach($file_type);

        $sixteen = Service::query()->create([
            'name' => 'دواليب حقائب وأحذية',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);
        $sixteen->file_type()->attach($file_type);
        $seventeen = Service::query()->create([
            'name' => 'اخرى',
            'specialties_id' => $architect->id,
            'unit' => 'عدد'
        ]);
        $seventeen->file_type()->attach($file_type);
    }

}
