<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsSupplierToUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        /*
          Schema::table('users', function (Blueprint $table) {
          $table->integer('supplier_account')->unsigned()->nullable();

          $table->foreign('supplier_account')
          ->references('id')
          ->on('inventory_suppliers')
          ->onUpdate('cascade')
          ->onDelete('cascade');
          }); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {

        });
    }

}
