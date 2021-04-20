<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenderToUsersUserProfilesTable extends Migration
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
                $table->string('gender')->after('phone')->nullable();
            });
        } catch(\Exception $e)
        {
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
            $table->dropColumn('gender');
        });
    }
}
