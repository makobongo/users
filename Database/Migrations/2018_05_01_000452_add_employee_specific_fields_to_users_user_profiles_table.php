<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeSpecificFieldsToUsersUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::table('users_user_profiles', function (Blueprint $table) {
                $table->timestamp('is_employee')->after('last_name')->nullable();
            });
        } catch(\Exception $e) {
            echo $e->getMessage();
        }
        
        try {
            Schema::table('users_user_profiles', function (Blueprint $table) {
                $table->timestamp('date_of_employment')->after('is_employee')->nullable();
                $table->unsignedInteger('department_id')->after('is_employee')->nullable();
            });
        } catch(\Exception $e) {
            echo $e->getMessage();
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_user_profiles', function (Blueprint $table) {
            $table->dropColumn('date_of_employment');
            $table->dropColumn('department_id');
        });
    }
}
