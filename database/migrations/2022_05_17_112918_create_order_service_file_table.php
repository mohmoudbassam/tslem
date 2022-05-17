<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderServiceFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_service_file', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_service_id')->nullable();
            $table->text('path')->nullable();
            $table->text('real_name')->nullable();
            $table->text('type');
            $table->foreign('order_service_id')->references('id')->on('order_service')->onDelete('SET NULL')->onUpdate('SET NULL');

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
        Schema::dropIfExists('order_service_file');
    }
}
