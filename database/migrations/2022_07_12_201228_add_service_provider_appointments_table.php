<?php

use App\Models\Appointment as Model;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceProviderAppointmentsTable extends Migration
{
    protected string $table;

    protected string $column = 'service_provider_id';

    public function __construct()
    {
        $this->table = (new Model())->getTable();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        !Schema::hasColumn($this->table, $this->column) && Schema::table($this->table, function (Blueprint $table) {
            $table->foreignId($this->column)->nullable()->after('support_id')->constrained((new User)->getTable())->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::hasColumn($this->table, $this->column) && Schema::table($this->table, function (Blueprint $table) {
            $table->dropForeign([$this->column]);
            $table->dropColumn($this->column);
        });
    }
}
