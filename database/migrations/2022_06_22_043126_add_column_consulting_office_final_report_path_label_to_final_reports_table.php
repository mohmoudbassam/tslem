<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnConsultingOfficeFinalReportPathLabelToFinalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('final_reports', function (Blueprint $table) {
            $table->string('consulting_office_final_report_path_label')->nullable()
                  ->after('consulting_office_final_report_path');
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
            $table->dropColumn('consulting_office_final_report_path_label');
        });
    }
}
