<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnContractorFinalReportPathLabelToFinalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('final_reports', function(Blueprint $table) {
            $table->string('contractor_final_report_path_label')->nullable()
                  ->after('contractor_final_report_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('final_reports', function(Blueprint $table) {
            $table->dropColumn('contractor_final_report_path_label');
        });
    }
}
