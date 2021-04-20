<?php

namespace Ignite\Users\Providers;

use Ignite\Evaluation\Entities\PartnerInstitution;
use Ignite\Users\Entities\EmployeeCategory;
use Ignite\Users\Entities\Role;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer([
            "users::users.create",
            "users::users.profile.*"
        ], function ($view) {
            $view->with([
                "partners"  => PartnerInstitution::all(),
                "roles"     => Role::all(),
                "employee_categories" => EmployeeCategory::all("name", "id"),
            ]);
        });
    }
}
