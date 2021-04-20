<?php

namespace Ignite\Users\Database\Seeders;

use Ignite\Users\Entities\Role;
use Ignite\Users\Entities\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleUsers = DB::table("role_users")->get();


        /*
         * Create new laratrust roles based on roles already created
         * Match all the new roles to the users
         */
        if(sizeof($roleUsers) > 0)
        {
            foreach($roleUsers as $roleUser)
            {
                $user = User::find($roleUser->user_id);

                $role = DB::table("roles")->where("id", $roleUser->role_id)->first();

                if(!is_null($role) and !is_null($user) and !$user->hasRole($role->slug))
                {
                    $trust = Role::firstOrNew([
                        "name" => $role->slug
                    ],[
                        "display_name" => $role->name
                    ]);

                    $trust->save();

                    $user->attachRole($trust);
                }
            }
        }

        $this->additionalRoles();
    }

    public function additionalRoles(){
        $roles = [
            "radiologist",
            "radiographer",
            "quality-assurance"
        ];

        foreach($roles as $role){
            Role::updateOrCreate([
                "name" => $role
            ]);
        }
    }

}
