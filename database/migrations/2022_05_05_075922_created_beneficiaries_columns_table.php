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
