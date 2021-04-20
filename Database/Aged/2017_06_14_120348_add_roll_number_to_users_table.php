<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRollNumberToUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users_user_profiles', function (Blueprint $table) {
            $table->string('roll_no')
                    ->nullable()
                    ->after('user_id')
                    ->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users_user_profiles', function (Blueprint $table) {
            $table->dropColumn('roll_no');
        });
    }

}
