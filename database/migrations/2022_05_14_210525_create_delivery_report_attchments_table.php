<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryReportAttchmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_report_attchments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("report_id")->nullable();
            $table->string('file_path')->nullable();
            $table->string("real_name")->nullable();
            $table->timestamps();

            $table->foreign("report_id")->references('id')->on('delivery_reports')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_report_attchments');
    }
}
