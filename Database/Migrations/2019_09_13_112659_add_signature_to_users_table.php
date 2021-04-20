<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSignatureToUsersTable extends Migration
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
                $table->text('signature')->after('enforce_password_reset')->nullable()->comment('base64 representation of the image');
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
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('signature');
            });
        } catch(\Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
