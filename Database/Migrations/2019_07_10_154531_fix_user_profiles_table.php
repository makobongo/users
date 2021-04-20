<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            // drop primary key first
            Schema::table('users_user_profiles', function (Blueprint $table) {
                $table->dropIndex('PRIMARY');
                $table->dropPrimary();
            });
        } catch(\Exception $e)
        {
            echo $e->getMessage();
        }
        
        try {
            // drop primary key first
            Schema::table('users_user_profiles', function (Blueprint $table) {
                $table->dropForeign('users_user_profiles_user_id_foreign');
            });
        } catch(\Exception $e)
        {
            echo $e->getMessage();
        }
    
        if(! Schema::hasColumn('users_user_profiles','id'))
            Schema::table('users_user_profiles', function (Blueprint $table) {
                $table->increments('id')->first();
            });
        
        // add foreign key
        Schema::table('users_user_profiles', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // why do this?? why revert??
    }
}
