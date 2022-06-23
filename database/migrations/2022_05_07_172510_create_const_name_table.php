<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstNameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('const_name', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->unsignedBigInteger("parnet_id");
            $table->timestamps();

            $table->foreign("parnet_id")->references("id")->on("const_parnet");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('const');
    }
}
