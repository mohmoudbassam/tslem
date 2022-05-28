<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiresFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficires_file', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['admin',
                'service_provider',
                'design_office',
                'Sharer',
                'consulting_office',
                'contractor',
                'Delivery',
                'Kdana'])->nullable();
            $table->string('file_name')->nullable();
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
        Schema::dropIfExists('beneficires_file');
    }
}
