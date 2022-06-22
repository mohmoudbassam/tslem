<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnMetaToFinalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('final_reports', function (Blueprint $table) {
            $table->longText('meta')
                  ->nullable()
                  ->after('consulting_office_final_report_approved');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('final_reports', function (Blueprint $table) {
            $table->dropColumn('meta');
        });
    }
}
