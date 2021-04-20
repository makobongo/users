<?php

namespace Ignite\Users\Composers;

use Ignite\Users\Foundation\PermissionManager;

/**
 * Description of PermissionViewComposer
 *
 * @author samuel
 */
class PermissionViewComposer {

    /**
     * @var PermissionManager
     */
    private $permissions;

    public function __construct(PermissionManager $permissions) {
        $this->permissions = $permissions;
    }

    public function compose($view) {
        // Get all permissions
        $view->permissions = $this->permissions->all();
    }

}
