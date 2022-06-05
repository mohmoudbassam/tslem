<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->foreignId("raft_company_box_id")->references("id")->on("raft_company_box")->cascadeOnDelete();
            $table->foreignId("raft_company_location_id")->references("id")->on("raft_company_location")->cascadeOnDelete();
            $table->foreignId("support_id")->references("id")->on("users")->cascadeOnDelete();
            $table->dateTime("start_at")->nullable();
            $table->enum('is_published', array('0','1'))->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sessions', function (Blueprint $table) {
            //
            $table->dropColumn('user_id');
            $table->dropColumn('support_id');
            $table->dropColumn('raft_company_box_id');
            $table->dropColumn('raft_company_location_id');
            $table->dropColumn('is_published');
        });
    }
}
