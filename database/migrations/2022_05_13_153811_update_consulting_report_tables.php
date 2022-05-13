<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConsultingReportTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("consulting_reports", function (Blueprint $table) {
            $table->foreign("order_id")->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign("user_id")->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table("consulting_report_attchments", function (Blueprint $table) {
            $table->foreign("report_id")->references('id')->on('consulting_reports')->cascadeOnDelete();

            $table->string("real_name")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("consulting_reports", function (Blueprint $table) {
            $table->dropConstrainedForeignId("order_id");
            $table->dropConstrainedForeignId("user_id");
        });

        Schema::table("consulting_report_attchments", function (Blueprint $table) {
            $table->dropConstrainedForeignId("report_id");

            $table->dropColumn("real_name");
        });
    }
}
