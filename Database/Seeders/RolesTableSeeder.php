<?php

namespace Ignite\Users\Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    protected $repo;

    public function __construct(\Ignite\Users\Repositories\RoleRepository $ropo) {
        $this->repo = $ropo;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $__users = mconfig('users.users.roles');
        foreach ($__users as $role) {
            $this->repo->create(['name' => $role, 'slug' => str_slug($role)]);
        }
    }

}
