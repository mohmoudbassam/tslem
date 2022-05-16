<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedTableServiceSpecialties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_specialties', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->text('name')->nullable();
            $table->text('unit')->nullable();
            $table->boolean('input')->default(1);
            $table->unsignedBigInteger('specialties_id')->nullable();
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
        //
    }
}
