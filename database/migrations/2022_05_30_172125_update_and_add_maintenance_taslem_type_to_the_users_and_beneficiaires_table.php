<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAndAddMaintenanceTaslemTypeToTheUsersAndBeneficiairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE users MODIFY COLUMN type ENUM('admin','service_provider','design_office', 'Sharer','consulting_office', 'contractor', 'Delivery', 'Kdana', 'raft_company', 'raft_center','taslem_maintenance');");
        \DB::statement("ALTER TABLE beneficiaries_columns MODIFY COLUMN type ENUM('admin','service_provider','design_office', 'Sharer','consulting_office', 'contractor', 'Delivery', 'Kdana', 'raft_company', 'raft_center,taslem_maintenance');");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('the_users_and_beneficiaires', function (Blueprint $table) {
            //
        });
    }
}
