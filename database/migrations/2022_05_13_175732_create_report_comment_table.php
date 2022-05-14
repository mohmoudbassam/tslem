<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_comment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->text('body')->nullable();
            $table->unsignedBigInteger('report_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('report_id')->references('id')->on('contractor_report')->onDelete('SET NULL')->onUpdate('SET NULL');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('SET NULL');

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
        Schema::dropIfExists('report_comment');
    }
}
