<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSeenNotesToRaftCompanyBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raft_company_box', function (Blueprint $table) {
            $table->boolean('seen_notes')->default(0);
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
            $table->dropColumn('seen_notes');
        });
    }
}
