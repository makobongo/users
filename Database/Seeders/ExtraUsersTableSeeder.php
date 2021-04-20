<?php

namespace Ignite\Users\Database\Seeders;

use Faker\Factory;
use Ignite\Users\Repositories\RoleRepository;
use Ignite\Users\Repositories\UserRepository;
use Illuminate\Database\Seeder;

class ExtraUsersTableSeeder extends Seeder {

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * @var RoleRepository
     */
    protected $role;

    /**
     * ExtraUsersTableSeeder constructor.
     * @param UserRepository $user
     * @param RoleRepository $roles
     */
    public function __construct(UserRepository $user, RoleRepository $roles) {
        $this->user = $user;
        $this->role = $roles;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $roles = $this->role->all();
        foreach ($roles as $role) {
            $faker = Factory::create();
            $user_data = [
                'username' => $role->slug,
                'password' => bcrypt($role->slug),
                'email' => $faker->email,
                'first_name' => $faker->firstName,
                'middle_name' => $faker->lastName,
                'last_name' => $faker->lastName,
                'phone' => '07' . $faker->numberBetween(10000000, 38999999),
                'job_description' => $role->name,
            ];
            $this->user->createUserWithProfile($user_data, $role->name);
        }
    }

}
