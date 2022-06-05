<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilesFullPathToRaftCompanyBoxTable extends Migration
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
            $table->text('file_first_name')->nullable();
            $table->text('file_second_name')->nullable();
            $table->text('file_third_name')->nullable();
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
            $table->dropColumn('file_first_name');
            $table->dropColumn('file_second_name');
            $table->dropColumn('file_third_name');
        });
    }
}
