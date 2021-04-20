<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEmployeeToEmployeeIdInDependantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dependants', function (Blueprint $table) {
            $table->dropForeign('dependants_employee_foreign');
        });

        Schema::table('dependants', function (Blueprint $table) {
            $table->dropColumn('employee');
            $table->unsignedInteger('employee_id')->after('id')->comment('the employee user the dependant is registered to');

            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dependants', function (Blueprint $table) {
            $table->dropForeign('dependants_employee_id_foreign');
        });

        Schema::table('dependants', function (Blueprint $table) {
            $table->dropColumn('employee_id');
            $table->unsignedInteger('employee')->after('id');

            $table->foreign('employee')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
