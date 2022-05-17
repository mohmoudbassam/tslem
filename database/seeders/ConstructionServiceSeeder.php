<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceFile;
use App\Models\ServiceFileType;
use App\Models\Specialties;
use Illuminate\Database\Seeder;

class ConstructionServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $construction = Specialties::query()->create([
            'name_ar' => 'الإنشائية',
            'name_en' => 'construction',
        ]);
        $map = ServiceFileType::query()->where('name_en', 'map')->first();
        $construction_accounts = ServiceFileType::query()->where('name_en', 'construction_accounts')->first();
        $first = Service::query()->create([
            'name' => 'إنشاء دورات مياه إضافية',
            'specialties_id' => $construction->id,
            'unit' => 'عدد'
        ]);

        $first->file_type()->attach($map);
        $first->file_type()->attach($construction_accounts);
        $second = Service::query()->create([
            'name' => 'إضافة تغطيات للمرات',
            'specialties_id' => $construction->id,
            'unit' => 'م2',
        ]);
        $second->file_type()->attach($map);
        $second->file_type()->attach($construction_accounts);
        $third = Service::query()->create([
            'name' => 'إضافة أو تعديل في الأسقف',
            'specialties_id' => $construction->id,
            'unit' => 'م2'
        ]);
        $third->file_type()->attach($map);
        $third->file_type()->attach($construction_accounts);
        $fourth = Service::query()->create([
            'name' => 'إضافة أو تعديل في الأسوار',
            'specialties_id' => $construction->id,
            'unit' => 'م2'
        ]);
        $fourth->file_type()->attach($map);
        $fourth->file_type()->attach($construction_accounts);
        $fifth = Service::query()->create([
            'name' => 'إضافة أحمال في الخيم',
            'specialties_id' => $construction->id,
            'unit' => 'م2'
        ]);
        $fifth->file_type()->attach($map);
        $fifth->file_type()->attach($construction_accounts);

        $sixth = Service::query()->create([
            'name' => 'إضافة أحمال في المطابخ',
            'specialties_id' => $construction->id,
            'unit' => 'م2'
        ]);
        $sixth->file_type()->attach($map);
        $sixth->file_type()->attach($construction_accounts);

        $seven = Service::query()->create([
            'name' => 'أعمال إنشائية جمالية',
            'specialties_id' => $construction->id,
            'unit' => 'م2'
        ]);
        $seven->file_type()->attach($map);
        $seven->file_type()->attach($construction_accounts);

        $eghit = Service::query()->create([
            'name' => 'اخري',
            'specialties_id' => $construction->id,
            'unit' => 'م2'
        ]);
        $eghit->file_type()->attach($map);
        $eghit->file_type()->attach($construction_accounts);

    }
}
