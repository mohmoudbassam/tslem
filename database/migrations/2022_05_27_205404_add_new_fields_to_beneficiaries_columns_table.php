<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToBeneficiariesColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiaries_columns', function (Blueprint $table) {
            $table->boolean('hajj_service_license')->nullable()->default(0);
            $table->boolean('hajj_service_license_end_date')->nullable()->default(0);
            $table->boolean('personalization_record')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beneficiaries_columns', function (Blueprint $table) {
            $table->dropColumn('hajj_service_license');
            $table->dropColumn('hajj_service_license_end_date');
            $table->dropColumn('personalization_record');
        });
    }
}
