<?php

namespace Ignite\Users\Widgets;

use Ignite\Users\Entities\User;
use Ignite\Core\Widgets\WidgetsInterface;

class AllUsers implements WidgetsInterface
{
    protected $view = 'users::widgets.all';
    protected $permissions = ['users.*'];

    /**
     * Get the data to be passed on to the view
     *
     * @return mixed
     */
    public function data()
    {
        return ['userCount' => User::count()];
    }

    /**
     * Get the view for the widget
     *
     * @return mixed
     */
    public function view()
    {
        return $this->view;
    }

    /**
     * Evaluate the user's permissions to view the widget
     *
     * @return bool
     */
    public function canView() : bool
    {
        return permit($this->permissions);
    }

}
