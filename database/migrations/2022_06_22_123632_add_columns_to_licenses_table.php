<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('licenses', function(Blueprint $table) {
            $table->tinyInteger('type')
                  ->default(1)
                  ->after('map_path');
            $table->string('final_attachment_path')
                  ->nullable()
                  ->default(null)
                  ->after('type');
            $table->string('map_path_label')
                  ->nullable()
                  ->default(null)
                  ->after('map_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('licenses', function(Blueprint $table) {
            $table->dropColumn([
                                   'type',
                                   'final_attachment_path',
                                   'map_path_label',
                               ]);
        });
    }
}
