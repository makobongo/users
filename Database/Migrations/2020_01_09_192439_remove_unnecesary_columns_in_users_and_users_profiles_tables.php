<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnnecesaryColumnsInUsersAndUsersProfilesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
    
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('gender');
            });
            
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    
        try {
    
            Schema::table('users_user_profiles', function (Blueprint $table) {
                $table->dropColumn('is_employee');
                $table->dropColumn('clinics');
            });
        
        } catch(Exception $e) {
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
        Schema::table('users', function (Blueprint $table) {
            // no. don't get it back
        });
    
        Schema::table('users_user_profiles', function (Blueprint $table) {
            // no. don't get it back
        });
        
    }
}
