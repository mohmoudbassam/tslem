<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampNumberAndBoxNumberColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiaries_columns', function (Blueprint $table) {
            $table->boolean("box_number")->nullable()->default(0);
            $table->boolean("camp_number")->nullable()->default(0);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->text("box_number")->nullable();
            $table->text("camp_number")->nullable();
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
            $table->dropColumn('box_number');
            $table->dropColumn('camp_number');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('box_number');
            $table->dropColumn('camp_number');
        });
    }
}
