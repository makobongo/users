<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersUserProfilesTableAddIdNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("users_user_profiles", function (Blueprint $table) {

//            $table->string("id_number")->after("phone");

//            $table->string("gender")->after("phone");

//            $table->string("dob")->after("phone");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("users_user_profiles", function (Blueprint $table) {

            $table->dropColumn("id_number");

            $table->dropColumn("gender");

            $table->dropColumn("dob");

        });
    }
}
