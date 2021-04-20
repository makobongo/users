<?php

use Ignite\Users\Repositories\RoleRepository;

function user_is_doc($user){
    if(! $user)
        return false;
    
    $roles = $user->roles()->pluck('name')->toArray();
    
    if(in_array('doctor', $roles)) {
        return true;
    }
    
    return false;
}

function get_external_institutions() {
    return Ignite\Evaluation\Entities\PartnerInstitution::all()->pluck('name', 'id');
}

/**
 * Return clinics for the user
 */
function getUserClininics()
{
    try {
        $clinics = Auth::user()->profile->clinics;
    } catch (\Exception $e) {
        $clinics = null;
    }
    return $clinics;
}


/**
 * get max dependants allowed per employee from setting
 */
if (! function_exists('users_get_max_dependants'))
{
    function users_get_max_dependants() {
        return m_setting('users.max-dependants-per-user');
    }
}

/**
 * Get paginations for different parts of the Users Module.
 * Opted for function in case the paginations require to be
 * retrieved via a setting instead of config option.
 * @param string $entity
 * @return int $pagination
 */
if (! function_exists('users_paginate'))
{
    function users_paginate($entity) {
        $paginations = mconfig('users.config.pagination');
        foreach($paginations as $key => $value) {
            if ($key == strtolower($entity))
                return (int)$value;
        }
        return $paginations['default'];
        }
}

/*
 * Get the resourceful permissions
 */
if (! function_exists('resourceful'))
{
    function resourceful($permissions)
    {
        return $permissions->filter(function($permission){

            return $permission->special == 0;

        })->groupBy("resource");
    }
}

/*
 * Get the special permissions
 */
if (! function_exists('special'))
{
    function special($permissions)
    {
        return $permissions->filter(function ($permission) {

            return $permission->special != 0;

        });
    }
}


/**
 * Get users in specified roles
 * @param $roles
 * @return \Illuminate\Database\Eloquent\Collection|static[]
 */
function users_in($roles)
{
    return \Ignite\Users\Entities\User::whereHas('roles', function ($query) use ($roles) {
        if (is_array($roles)) {
            $query->whereIn('id', $roles);
        } else if (is_int($roles)) {
            $query->where('id', $roles);
        } else {
            $query->where('slug', $roles);
        }
    })->with('profile')->get();
}

/**
 * Get all user roles
 * @return mixed
 */
function all_roles()
{
    return app(RoleRepository::class)->all()->reject(function ($name) {
        return $name->slug == 'sudo';
    })->pluck('name', 'id');
}



if(! function_exists('sanitizeDomainUrl'))
{
    /**
     * Sanitize URL
     *
     * @var string
     * @return string
     */
    function sanitizeDomainUrl(string $str) : string
    {
        // $input = 'www.google.co.uk/';
        // in case scheme relative URI is passed, e.g., //www.google.com/
        $str = trim($str, '/');

        // If scheme not included, prepend it
        if (! preg_match('#^http(s)?://#', $str)) {
            $str = 'http://' . $str;
        }

        $urlParts = parse_url($str);

        // remove www
        $domain = preg_replace('/^www\./', '', $urlParts['host']);

        // output: google.co.uk
        return $domain;
    }
}

