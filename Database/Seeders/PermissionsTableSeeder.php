<?php

namespace Ignite\Users\Database\Seeders;

use Ignite\Users\Entities\Permission;
use Ignite\Users\Entities\Role;
use Ignite\Users\Library\Traits\PermissionsGeneratorTrait;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Nwidart\Modules\Facades\Module;

class PermissionsTableSeeder extends Seeder
{
    use PermissionsGeneratorTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission::query()->delete();

        $modules = array_map("strtolower", array_keys(Module::all()));

        $general = $resource = [];

        foreach($modules as $module)
        {
            $permissions = mconfig("$module.laratrust");

            if($permissions)
            {
                array_push($general, [$module => $permissions['general']]);

                array_push($resource, [$module => $permissions['resource']]);
            }
        }

        /*
         * Find a permission by a name and updates it if it exists or deletes it otherwise
         */
        foreach($this->generate($general, $resource) as $permission)
        {
            Permission::updateOrCreate([
                "name" => $permission["name"]
            ], array_except($permission, ["name"]));
        }

        $this->attachToSudo();
    }

    public function attachToSudo()
    {
        $sudo = Role::where('name', 'sudo')->first();

        if($sudo)
            $sudo->syncPermissions(Permission::all());
    }
}
