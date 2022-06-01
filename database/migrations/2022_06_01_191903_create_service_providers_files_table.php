<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProvidersFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers_files', function (Blueprint $table) {
            $table->id();
            $table->text('path')->nullable();
            $table->text('real_name')->nullable();
            $table->foreignId('service_providers_id')->references('id')->on('users')->cascadeOnDelete();
            $table->integer('type')->nullable();
            $table->foreignId('maintainers_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('service_providers_files');
    }
}
