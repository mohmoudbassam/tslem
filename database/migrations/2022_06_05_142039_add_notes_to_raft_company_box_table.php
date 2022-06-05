<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesToRaftCompanyBoxTable extends Migration
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
            $table->text('tasleem_notes')->nullable();
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
            $table->dropColumn('tasleem_notes');
        });
    }
}
