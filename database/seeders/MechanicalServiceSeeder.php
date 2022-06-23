<?php

namespace Database\Seeders;

use App\Models\Service;

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

        $first = Service::query()->create([
            'name' => 'اضافة دورات مياه ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $second = Service::query()->create([
            'name' => 'اضافة مغاسل',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'

        ]);

        $third = Service::query()->create([
            'name' => 'اضافة مباول',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $fourth=  Service::query()->create([
            'name' => 'اضافة او تعديل في التكييف',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $fifth = Service::query()->create([
            'name' => 'اضافة او تعديل في صرف المطر للخيام',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $sixth = Service::query()->create([
            'name' => 'اضافة مراوح شفط',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $seveth = Service::query()->create([
            'name' => 'تعديل أو اضافة رشاشات الحريق ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $egth = Service::query()->create([
            'name' => 'اضافة سخانات ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $nine = Service::query()->create([
            'name' => 'اضافة مضخات ضغط الماء ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $ten = Service::query()->create([
            'name' => 'اضافة مشارب مياه',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $elevent = Service::query()->create([
            'name' => 'اضافة رشاشات مياه ترطيب ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $twilv = Service::query()->create([
            'name' => 'تعديل او اضافة صرف التكييف ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $thirteen = Service::query()->create([
            'name' => 'تعديل في صرف دورات المياه الاضافية',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $fourteen = Service::query()->create([
            'name' => 'تعديل في مواسير خزانات الكيروسين ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

        $fifteen = Service::query()->create([
            'name' => 'اخري ',
            'specialties_id' => $mechanical->id,
            'unit' => 'عدد'
        ]);

    }
}
