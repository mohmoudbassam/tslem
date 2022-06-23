<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('file');
        });

        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->text('file')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('item_id')->nullable();
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
        Schema::dropIfExists('files');
    }
}
