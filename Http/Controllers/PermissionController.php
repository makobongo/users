<?php

namespace Ignite\Users\Http\Controllers;

use Illuminate\Routing\Controller;

class PermissionController extends Controller
{
    /*
     * Get permissions on a user
     */
    public function allowed()
    {
        return doe()->allPermissions();
    }
}
