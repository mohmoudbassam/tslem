<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_file', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('file_id')->nullable();
            $table->foreign('service_id')->references('id')->on('service_specialties')->onDelete('SET NULL')->onUpdate('SET NULL');
            $table->foreign('file_id')->references('id')->on('service_file_type')->onDelete('SET NULL')->onUpdate('SET NULL');

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
        Schema::dropIfExists('service_file');
    }
}
