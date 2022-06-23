<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();

            $table->text('unit')->nullable();
            $table->text('kw')->nullable();
            $table->foreign('service_id')->references('id')->on('service_specialties')->onDelete('SET NULL')->onUpdate('SET NULL');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('SET NULL')->onUpdate('SET NULL');

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
        Schema::dropIfExists('order_service');
    }
}
