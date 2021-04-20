<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeChitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::table('employee_chits', function (Blueprint $table) {
                $table->renameColumn('employee', 'employee_id');
                $table->renameColumn('user', 'user_id');
            });
        } catch (\Exception $e) {

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            Schema::table('employee_chits', function (Blueprint $table) {
                $table->renameColumn('employee_id', 'employee');
                $table->renameColumn('user_id', 'user');
            });
        } catch (\Exception $e) {

        }
    }
}
