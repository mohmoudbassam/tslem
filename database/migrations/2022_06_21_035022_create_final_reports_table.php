<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('contractor_final_report_path')->nullable();
            $table->text('contractor_final_report_note')->nullable();
            $table->boolean('contractor_final_report_approved')->nullable()->default(false);
            $table->string('consulting_office_final_report_path')->nullable();
            $table->text('consulting_office_final_report_note')->nullable();
            $table->boolean('consulting_office_final_report_approved')->nullable()->default(false);
            $table->timestamps();

            $table->foreign("order_id")->references("id")->on("orders");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('final_reports');
    }
}
