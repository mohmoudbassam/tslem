<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_report', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('contractor_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('SET NULL')->onUpdate('SET NULL');
            $table->foreign('contractor_id')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('SET NULL');

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
        Schema::dropIfExists('contractor_report');
    }
}
