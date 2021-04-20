<?php

use Ignite\Users\Composers\PermissionViewComposer;
use Ignite\Users\Composers\UsernameViewComposer;

view()->composer([ 'users::partials.permissions', 'users::partials.permissions-create',], PermissionViewComposer::class);
view()->composer(['partials.sidebar-nav', 'partials.top-nav', 'layouts.app', 'partials.*'], UsernameViewComposer::class);
