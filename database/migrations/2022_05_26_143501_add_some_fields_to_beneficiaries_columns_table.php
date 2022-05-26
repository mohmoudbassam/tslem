<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldsToBeneficiariesColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiaries_columns', function (Blueprint $table) {
            $table->boolean('company_owner_id_photo')->nullable()->default(1);
            $table->boolean('commissioner_id_photo')->nullable()->default(1);
            $table->boolean('commissioner_photo')->nullable()->default(1);
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
            $table->dropColumn('company_owner_id_photo');
            $table->dropColumn('commissioner_id_photo');
            $table->dropColumn('commissioner_photo');
        });
    }
}
