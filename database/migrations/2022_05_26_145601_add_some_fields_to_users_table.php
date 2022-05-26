<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_owner_id_photo')->nullable()->after('is_file_uploaded');
            $table->string('commissioner_id_photo')->nullable()->after('is_file_uploaded');
            $table->string('commissioner_photo')->nullable()->after('is_file_uploaded');
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
            $table->dropColumn('company_owner_id_photo');
            $table->dropColumn('commissioner_id_photo');
            $table->dropColumn('commissioner_photo');
        });
    }
}
