<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorSpecialtiesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_specialties_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreignId("specialties_id")->references("id")->on("contractor_specialties")->cascadeOnDelete();
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
        Schema::dropIfExists('contractor_specialties_pivot');
    }
}
