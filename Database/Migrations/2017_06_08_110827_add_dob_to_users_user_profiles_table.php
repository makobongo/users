<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDobToUsersUserProfilesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        try {
            Schema::table('users_user_profiles', function (Blueprint $table) {
                $table->date('dob')
                    ->after('last_name')
                    ->nullable();
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
    public function down() {
        Schema::table('users_user_profiles', function (Blueprint $table) {
            $table->dropColumn(['dob']);
        });
    }

}
