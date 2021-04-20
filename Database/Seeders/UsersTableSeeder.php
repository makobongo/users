<?php

namespace Ignite\Users\Database\Seeders;

use Ignite\Settings\Entities\Clinics;
use Ignite\Users\Entities\Role;
use Ignite\Users\Entities\User;
use Ignite\Users\Repositories\UserRepository;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate(['name' => 'sudo'])->id;

        foreach($this->sudo() as $sudo)
        {
            $user = User::firstOrcreate(["username" => $sudo["user"]["username"]], $sudo['user']);

            if(!$user->profile)
            {
                $user->profile()->create($sudo['profile']);
            }

            $this->activate_user($user->id);
            
            $this->allocateFacility($user);
    
            $user->attachRole($role);
        }
    }

    public function sudo()
    {
        return [
            [
                'user' => [
                    'email' => 'ace@gmail.com',
                    'username' => 'ace',
                    'password' => bcrypt("ace123")
                ],

                'profile' => [
                    "first_name" => "Ace",
                    "last_name" => "Admin",
                    "title" => 0,
                    "phone" => "0700000000"
                ],
            ],

            [
                'user' => [
                    'email' => 'sudo@gmail.com',
                    'username' => 'sudo',
                    'password' => bcrypt("duso")
                ],

                'profile' => [
                    "first_name" => "SU",
                    "last_name" => "Do",
                    "title" => 0,
                    "phone" => "0700000000"
                ],
            ],
        ];
    }

    /*
     * Gives a user activation
     */
    public function activate_user($id)
    {
        $activation = new \Ignite\Users\Entities\Activation;
        $activation->user_id = $id;
        $activation->code = $this->generateCode(40);
        $activation->completed = 1;
        return $activation->save();
    }
    
    public function allocateFacility($user)
    {
        $clinics = Clinics::whereIn("name", get_clinics())->get()->pluck("id")->all();
    
        return $user->clinics()->sync($clinics);
    }

    /*
     * Generates a random activation code
     */
    public function generateCode($length)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}
