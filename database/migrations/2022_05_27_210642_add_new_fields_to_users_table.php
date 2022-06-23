<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('hajj_service_license')->nullable()->after('company_owner_id_photo');
            $table->date('hajj_service_license_end_date')->nullable()->after('company_owner_id_photo');
            $table->string('personalization_record')->nullable()->after('company_owner_id_photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('hajj_service_license');
            $table->dropColumn('hajj_service_license_end_date');
            $table->dropColumn('personalization_record');
        });
    }
}
