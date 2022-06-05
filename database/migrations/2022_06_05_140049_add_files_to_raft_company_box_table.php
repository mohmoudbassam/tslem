<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilesToRaftCompanyBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raft_company_box', function (Blueprint $table) {
            //
            $table->text('file_first')->nullable();
            $table->text('file_second')->nullable();
            $table->text('file_third')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('raft_company_box', function (Blueprint $table) {
            //
            $table->dropColumn('file_first');
            $table->dropColumn('file_second');
            $table->dropColumn('file_third');
        });
    }
}
