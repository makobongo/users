<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveIsEmployeeInUsersUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('users_user_profiles', 'is_employee')) {
            Schema::table('users_user_profiles', function (Blueprint $table) {
                $table->dropColumn('is_employee');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(!Schema::hasColumn('users_user_profiles', 'is_employee')) {
            Schema::table('users_user_profiles', function (Blueprint $table) {
                $table->boolean('is_employee')->after('last_name')->default(0);
            });
        }
    }
}
