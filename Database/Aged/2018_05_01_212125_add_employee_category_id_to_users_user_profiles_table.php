<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeCategoryIdToUsersUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_user_profiles', function (Blueprint $table) {
            $table->unsignedInteger('employee_category_id')->nullable()->after('is_employee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_user_profiles', function (Blueprint $table) {
            $table->dropColumn('employee_category_id');
        });
    }
}
