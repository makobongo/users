<?php

namespace Ignite\Users\Repositories;

use Ignite\Users\Entities\Permission;
use Ignite\Users\Entities\Role;

class RoleRepository
{
    /*
     * Get all roles
     */
    public function all()
    {
        return Role::latest()->get();
    }

    /*
     * Persist a new role into the database
     */
    public function create()
    {
        return Role::create(request()->all());
    }

    /*
     * Persist a new role into the database
     */
    public function find($id)
    {
        return Role::find($id);
    }

    /*
     * Group all permissions according to module
     * Useful for displaying for role and user permissions
     */
    public function groupedPermissions()
    {
        $permissions = Permission::all()->groupBy('module');

        foreach($permissions as $collection)
        {
            $collection->groupBy('special');
        }

        return $permissions;
    }

    /**
     * update role
     *
     * @param Role $role
     *
     * @return Role
     */
    public function update(Role $role)
    {
        // confirm new name does not conflict with existing roles
        $id = $role->id;
        $newName = request()->name;
        $exists = false;

        Role::all()->map(function($item) use ($id) {
            if($item->id <> $id) {
                return $item;
            }
        })->each(function($item) use ($newName, &$exists) {
            if(strtolower(@$item->name) == strtolower($newName)) {
                $exists = true;
            }
        });

        if($exists) {
            return false; // cannot update it
        }

        $role->name = request()->name;
        $role->description = request()->description;
        $role->save();

        return $role;
    }
}
