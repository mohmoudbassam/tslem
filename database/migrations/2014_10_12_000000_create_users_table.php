<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->boolean('enabled')->default(1);
            $table->boolean('verified')->default(0);
            $table->string('designer_type')->nullable();
            $table->enum('type', ['admin',
                'service_provider',
                'design_office',
                'Sharer',
                'consulting_office',
                'contractor',
                'Delivery',
                'Kdana'])->nullable();

            /////
            $table->string('company_name')->nullable();
            $table->enum('company_type', [
                'organization', 'office'
            ])->nullable();
            $table->string('company_owner_name')->nullable();
            $table->string('license_number')->nullable();
            $table->string('commercial_record')->nullable();
            $table->string('website')->nullable();
            $table->string('responsible_name')->nullable();
            $table->string('id_number')->nullable();
            $table->date('id_date')->nullable();
            $table->string('source')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('telephone')->nullable();
            $table->string('city')->nullable();
            $table->string('employee_number')->nullable();


            $table->text('commercial_file')->nullable();//ملف السجل التجاري
            $table->text('commercial_file_end_date')->nullable();
            $table->text('rating_certificate')->nullable();///شهادة تصنيف وطني
            $table->text('rating_certificate_end_date')->nullable();
            $table->text('address_file')->nullable();//العنوان الوطني
            $table->text('profession_license')->nullable();//مزاولة مهنة
            $table->text('profession_license_end_date')->nullable();//
            $table->text('business_license')->nullable();//شهادةالنشاط التاري
            $table->text('business_license_end_date')->nullable();


            $table->text('social_insurance_certificate')->nullable();///شهادة التأمينات الاجتماعي
            $table->text('social_insurance_certificate_end_date')->nullable();///

            $table->text('certificate_of_zakat')->nullable();///شهادةالزكاة والدخل
            $table->text('date_of_zakat_end_date')->nullable();

            $table->text('saudization_certificate')->nullable();///شهادةالسعودة
            $table->text('saudization_certificate_end_date')->nullable();///شهادةالسعودة
            ///
            $table->text('chamber_of_commerce_certificate')->nullable();///شهادة الغرفة التجارية
            $table->text('chamber_of_commerce_certificate_end_date')->nullable();///شهادة الغرفة التجارية
            $table->text('tax_registration_certificate')->nullable();///شهادة تسجيل الضريبة
            $table->text('wage_protection_certificate')->nullable();///شهادة حماية الضريبة
            $table->text('memorandum_of_association')->nullable();///عقد التاسيس
            $table->text('cv_file')->nullable();///الاعمال السابقة للمقاول
            ///
            ///
            $table->text('reject_reason')->nullable();


            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
