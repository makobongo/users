<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdNumberToUsersUserProfilesTable extends Migration
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
                $table->integer('id_number')->nullable()->after('roll_no');
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
                $table->dropColumn('id_number');
            });
        } catch (\Exception $e) {

        }
    }
}
