<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIDToUserProfilesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users_user_profiles', function (Blueprint $table) {
            $table->string('id_number')
                    ->nullable()
                    ->after('user_id')
                    ->unique();

            $table->boolean('is_employee')
                    ->after('pin')
                    ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users_user_profiles', function (Blueprint $table) {
            $table->dropColumn(['id_number', 'is_employee']);
        });
    }

}
