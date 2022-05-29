<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRaftCompanyTypeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE users MODIFY COLUMN type ENUM('admin','service_provider','design_office', 'Sharer','consulting_office', 'contractor', 'Delivery', 'Kdana', 'raft_company');");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE users MODIFY COLUMN type ENUM('admin','service_provider','design_office', 'Sharer','consulting_office', 'contractor', 'Delivery', 'Kdana');");

    }
}
