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
            $table->string('name')->unique;
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->boolean('enabled')->default(1);
            $table->enum('type', ['admin',
                'service_provider',
                'design_office',
                'Sharer',
                'consulting_office',
                'contractor',
                'Delivery',
                'Kdana'])->nullable();

            /////
            $table->enum('company_name', [
                'organization', 'office'
            ])->nullable();
            $table->string('company_type')->nullable();
            $table->string('company_owner_name')->nullable();
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
