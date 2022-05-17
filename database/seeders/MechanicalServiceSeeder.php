<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceFile;
use App\Models\ServiceFileType;
use App\Models\Specialties;
use Illuminate\Database\Seeder;

class MechanicalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $mechanical = Specialties::query()->create([
            'name_ar' => 'الميكانيكة',
            'name_en' => 'mchanical',
        ]);
        $file_type = ServiceFileType::query()->where('name_en', 'ele')->first();
        $map = ServiceFileType::query()->where('name_en', 'map')->first();
        $first = Service::query()->create([
            'name' => 'اضافة دورات مياه ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $first->file_type()->attach($map);
        $first->file_type()->attach($file_type);
        $second = Service::query()->create([
            'name' => 'اضافة مغاسل',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'

        ]);
        $second->file_type()->attach($map);
        $second->file_type()->attach($file_type);
        $third = Service::query()->create([
            'name' => 'اضافة مباول',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $third->file_type()->attach($map);
        $third->file_type()->attach($file_type);
        $fourth=  Service::query()->create([
            'name' => 'اضافة او تعديل في التكييف',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $fourth->file_type()->attach($map);
        $fourth->file_type()->attach($file_type);
        $fifth = Service::query()->create([
            'name' => 'اضافة او تعديل في صرف المطر للخيام',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $fifth->file_type()->attach($map);
        $fifth->file_type()->attach($file_type);
        $sixth = Service::query()->create([
            'name' => 'اضافة مراوح شفط',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $sixth->file_type()->attach($map);
        $sixth->file_type()->attach($file_type);
        $seveth = Service::query()->create([
            'name' => 'تعديل أو اضافة رشاشات الحريق ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $seveth->file_type()->attach($map);
        $seveth->file_type()->attach($file_type);
        $egth = Service::query()->create([
            'name' => 'اضافة سخانات ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $egth->file_type()->attach($map);
        $egth->file_type()->attach($file_type);
        $nine = Service::query()->create([
            'name' => 'اضافة مضخات ضغط الماء ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $nine->file_type()->attach($map);
        $nine->file_type()->attach($file_type);
        $ten = Service::query()->create([
            'name' => 'اضافة مشارب مياه',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $ten->file_type()->attach($map);
        $ten->file_type()->attach($file_type);
        $elevent = Service::query()->create([
            'name' => 'اضافة رشاشات مياه ترطيب ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $elevent->file_type()->attach($map);
        $elevent->file_type()->attach($file_type);
        $twilv = Service::query()->create([
            'name' => 'تعديل او اضافة صرف التكييف ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $twilv->file_type()->attach($map);
        $twilv->file_type()->attach($file_type);
        $thirteen = Service::query()->create([
            'name' => 'تعديل في صرف دورات المياه الاضافية',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $thirteen->file_type()->attach($map);
        $thirteen->file_type()->attach($file_type);
        $fourteen = Service::query()->create([
            'name' => 'تعديل في مواسير خزانات الكيروسين ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $fourteen->file_type()->attach($map);
        $fourteen->file_type()->attach($file_type);
        $fifteen = Service::query()->create([
            'name' => 'اخري ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);
        $fifteen->file_type()->attach($map);
        $fifteen->file_type()->attach($file_type);
    }
}
