<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHrEmployeeRelatedFieldsToUsersUserProfilesTable extends Migration
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
                $table->unsignedInteger('department_id')->nullable()->after('password');
                //            $table->boolean('is_employee')->default(0)->after('password');
            });
    
            Schema::table('users_user_profiles', function (Blueprint $table) {
                //            $table->timestamp('date_of_employment')->nullable()->after('clinics');
                $table->string('staff_number')->nullable()->after('clinics');
            });
    
            Schema::table('users_user_profiles', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('date_of_employment');
                $table->string('coverphoto')->nullable()->after('date_of_employment');
                $table->string('location')->nullable()->after('date_of_employment');
                $table->string('district')->nullable()->after('date_of_employment');
                $table->string('town')->nullable()->after('date_of_employment');
                $table->string('county')->nullable()->after('date_of_employment');
                $table->string('country')->nullable()->after('date_of_employment');
                $table->string('address')->nullable()->after('date_of_employment');
                $table->string('work_email')->nullable()->after('date_of_employment');
                $table->string('secondary_email')->nullable()->after('date_of_employment');
                $table->string('secondary_phone')->nullable()->after('date_of_employment');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('department_id');
            $table->dropColumn('employee_id');
            $table->dropColumn('is_employee');
        });

        Schema::table('users_user_profiles', function (Blueprint $table) {
            $table->dropColumn('date_of_employment');
            $table->dropColumn('staff_number');
            $table->dropColumn('location');
            $table->dropColumn('district');
            $table->dropColumn('town');
            $table->dropColumn('county');
            $table->dropColumn('country');
            $table->dropColumn('address');
            $table->dropColumn('work_email');
            $table->dropColumn('secondary_email');
            $table->dropColumn('secondary_phone');
            $table->dropColumn('coverphoto');
            $table->dropColumn('notes');
        });
    }
}
