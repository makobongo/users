<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleNoToUsersTable extends Migration
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
                $table->string('roll_no')->after('user_id')->nullable()->comment('check roll number');
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
            Schema::table('users_user_profiles', function (Blueprint $table) {
                $table->dropColumn('roll_no');
            });
        } catch (\Exception $e) {

        }
    }
}
