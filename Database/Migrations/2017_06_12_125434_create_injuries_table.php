<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('injuries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee')->unsigned();
            $table->string('check_roll_number')->nullable();
            $table->string('injury');
            $table->string('statement')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('user')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('employee')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('injuries');
    }

}
