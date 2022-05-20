<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedDersingerRejectedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designer_rejected', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('designer_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('SET NULL')->onUpdate('SET NULL');
            $table->foreign('designer_id')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('SET NULL');
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
