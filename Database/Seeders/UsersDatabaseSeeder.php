<?php

namespace Ignite\Users\Database\Seeders;

use Illuminate\Database\Seeder;

class UsersDatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
//        $this->call(RolesTableSeeder::class);
//        $this->call(UsersTableSeeder::class);

         $this->call(UserRolesTableSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(PermissionsTableSeeder::class);
    }
}
