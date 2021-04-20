<?php

namespace Ignite\Users\Library\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheRecursiveDataTrait
{
    /*
     * Store the user in a cache
     */
    public function cacheUser()
    {
        Cache::forever("doe", \Auth::user());
    }

    /*
     * Set all the permissions in a cache
     */
    public function cachePermissions()
    {
        Cache::forever("permissions", Cache::get("doe")->allPermissions());
    }
}
