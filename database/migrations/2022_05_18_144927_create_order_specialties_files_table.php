<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSpecialtiesFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_specialties_files', function (Blueprint $table) {
            $table->id();
            $table->text('path')->nullable();
            $table->text('real_name')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('specialties_id')->nullable();
            $table->integer('type')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('SET NULL')->onUpdate('SET NULL');
            $table->foreign('specialties_id')->references('id')->on('specialties')->onDelete('SET NULL')->onUpdate('SET NULL');

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
        Schema::dropIfExists('order_specialties_files');
    }
}
