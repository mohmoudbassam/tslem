<?php

namespace Database\Seeders;

use App\Models\Service;
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


        $construction  =  Specialties::query()->create([
            'name_ar'=>'الإنشائية',
            'name_en'=>'construction',
        ]);
        Service::query()->create([
            'name' => 'إنشاء دورات مياه إضافية',
            'specialties_id' => $construction->id
        ]); Service::query()->create([
            'name' => 'إضافة تغطيات للمرات',
            'specialties_id' => $construction->id
        ]); Service::query()->create([
            'name' => 'إضافة أو تعديل في الأسقف',
            'specialties_id' => $construction->id
        ]); Service::query()->create([
            'name' => 'إضافة أو تعديل في الأسوار',
            'specialties_id' => $construction->id
        ]); Service::query()->create([
            'name' => 'إضافة أحمال في الخيم',
            'specialties_id' => $construction->id
        ]); Service::query()->create([
            'name' => 'إضافة أحمال في المطابخ',
            'specialties_id' => $construction->id
        ]);Service::query()->create([
            'name' => 'أعمال إنشائية جمالية',
            'specialties_id' => $construction->id
        ]);Service::query()->create([
            'name' => 'اخري',
            'specialties_id' => $construction->id
        ]);
    }
}
