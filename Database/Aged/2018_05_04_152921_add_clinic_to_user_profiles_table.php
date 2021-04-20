<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClinicToUserProfilesTable extends Migration
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
                $table->text('clinics')->comment('The clinics a user belongs to')->after('user_id');
            });
        } catch(\Exception $e) {
            
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
            $table->dropColumn('clinics');
        });
    }
}
