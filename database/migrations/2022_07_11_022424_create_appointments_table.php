<?php

use App\Models\Appointment;
use App\Models\RaftCompanyBox;
use App\Models\RaftCompanyLocation;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    protected string $table;

    public function __construct()
    {
        $this->table = (new Appointment())->getTable();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignId("raft_company_box_id")->constrained((new RaftCompanyBox)->getTable())->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId("raft_company_location_id")->constrained((new RaftCompanyLocation())->getTable())->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId("support_id")->constrained((new User)->getTable())->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp("start_at")->nullable();
            $table->boolean('is_published');
            $table->string('notes')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists($this->table);
    }
}
