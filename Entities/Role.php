<?php

namespace Ignite\Users\Entities;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $table = "users_roles";

    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    protected $with = [
        'permissions'
    ];

    public function getRouteKeyName()
    {
        return "name";
    }

    /*
     * When creating the name, add the display name as well
     */
    public function setDisplayNameAttribute($value)
    {
        $this->attributes['name'] = str_slug(strtolower($value), "-");

        $this->attributes['display_name'] = $value;
    }
    
    /**
     * return name if display name is empty
     * @return mixed
     */
    public function getDisplayNameAttribute()
    {
        return ucwords($this->attributes['display_name'] ?: $this->attributes['name']);
    }

    /*
     * When deleting a role, delete all the users and the user profiles as well
     * Consider detaching only - not deleting
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function($role) {
            $role->users->each(function($user){
                $user->profile()->delete();
            });
        });
    }

    /*
     * Fetch all the roles apart from sudo
     */
    public function scopeHumans($query)
    {
        $query->where('name', '<>', 'sudo');
    }
}
