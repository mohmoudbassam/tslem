<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvgRaftCompanyLocationTable extends Migration
{
    /** @var string */
    protected string $table = 'raft_company_location';

    /** @var string */
    protected string $column = 'avg';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        !Schema::hasColumn($this->table, $this->column) && Schema::table($this->table, fn(Blueprint $table) => $table->integer($this->column)->default(0)->after('name'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::hasColumn($this->table, $this->column) && Schema::dropColumns($this->table, [$this->column]);
    }
}
