<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSpecialtyObligationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_specialty_obligations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id")
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId("specialties_id")
                ->constrained("specialties")
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string("path");
            $table->enum("type", ["gypsum_obligation", "kitchen_obligation", "storage_obligation", "entrance_obligation", "aisle_obligation", "electricity_obligation", "air_conditioner_obligation", "toilet_obligation"])->default("kitchen_obligation");
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
        Schema::dropIfExists('order_specialty_obligations');
    }
}
