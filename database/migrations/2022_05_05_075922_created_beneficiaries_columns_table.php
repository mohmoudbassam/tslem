<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedBeneficiariesColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiaries_columns', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->enum('type', ['admin',
                'service_provider',
                'design_office',
                'Sharer',
                'consulting_office',
                'contractor',
                'Delivery',
                'Kdana']);
            $table->boolean('company_name')->default(0);
            $table->boolean('company_type')->default(0);
            $table->boolean('company_owner_name')->default(0);
            $table->boolean('commercial_record')->default(0);
            $table->boolean('website')->default(0);
            $table->boolean('responsible_name')->default(0);
            $table->boolean('id_number')->default(0);
            $table->boolean('id_date')->default(0);
            $table->boolean('source')->default(0);
            $table->boolean('email')->default(0);
            $table->boolean('phone')->default(0);
            $table->boolean('address')->default(0);
            $table->boolean('telephone')->default(0);
            $table->boolean('city')->default(0);
            $table->boolean('employee_number')->default(0);

            ///files

            $table->boolean('commercial_file')->default(0);//ملف السجل التجاري
            $table->boolean('commercial_date_end')->default(0);
            $table->boolean('rating_certificate')->default(0);///شهادة تصنيف وطني
            $table->boolean('rating_certificate_date_end')->default(0);
            $table->boolean('address_file')->default(0);//العنوان الوطني
            $table->boolean('profession_license')->default(0);//مزاولة مهنة
            $table->boolean('profession_license_date_end')->default(0);//
            $table->boolean('business_license')->default(0);//شهادةالنشاط التاري
            $table->boolean('business_license_end_date')->default(0);


            $table->boolean('social_insurance_certificate')->default(0);///شهادة التأمينات الاجتماعي
            $table->boolean('social_insurance_certificate_end_date')->default(0);///
            ///
            $table->boolean('certificate_of_zakat')->default(0);///شهادةالزكاة والدخل
            $table->boolean('date_of_zakat_end_date')->default(0);

            $table->boolean('saudization_certificate')->default(0);///شهادةالسعودة
            $table->boolean('saudization_certificate_end_date')->default(0);///شهادةالسعودة
            ///
            $table->boolean('chamber_of_commerce_certificate')->default(0);///شهادة الغرفة التجارية
            $table->boolean('chamber_of_commerce_certificate_end_date')->default(0);///شهادة الغرفة التجارية
            $table->boolean('tax_registration_certificate')->default(0);///شهادة تسجيل الضريبة
            $table->boolean('wage_protection_certificate')->default(0);///شهادة حماية الضريبة
            $table->boolean('memorandum_of_association')->default(0);///عقد التاسيس


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
