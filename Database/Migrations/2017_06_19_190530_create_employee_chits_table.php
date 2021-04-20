<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeChitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('employee_chits'))
        {
            Schema::create('employee_chits', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsigned();
                $table->integer('user_id')->unsigned()->nullable();
                $table->string('category');
                $table->string('document_type')->nullable();
                $table->string('filepath')->nullable();
                $table->string('filename')->nullable();
                $table->string('mime')->nullable();
                $table->longText('description')->nullable();
                $table->integer('duration')->nullable();
                $table->string('time_measure', 20)->nullable();
    
                $table->timestamps();
    
                $table->foreign('user_id')
                        ->references('id')
                        ->on('users')
                        ->onUpdate('restrict')
                        ->onDelete('restrict');
    
                $table->foreign('employee_id')
                        ->references('id')
                        ->on('users')
                        ->onUpdate('cascade')
                        ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_chits');
    }
}
