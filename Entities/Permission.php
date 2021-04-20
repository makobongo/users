<?php

namespace Ignite\Users\Entities;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    protected $fillable = [
        'name', 'display_name', 'description', 'special', 'resource', 'module'
    ];

    public static function boot()
    {
        parent::boot();

        $role = Role::where('name', 'sudo')->get();

        static::created(function($permission) use($role){

            $permission->roles()->attach($role);

        });
    }
}
