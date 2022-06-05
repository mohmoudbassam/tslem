<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRaftCompanyBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raft_company_box', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raft_company_location_id')->references('id')->on('raft_company_location')->cascadeOnDelete();
            $table->text('box')->nullable();
            $table->text('camp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_raft_company_box');
    }
}
