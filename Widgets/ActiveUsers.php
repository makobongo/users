<?php

namespace Ignite\Users\Widgets;

use Ignite\Users\Entities\User;
use Ignite\Core\Widgets\WidgetsInterface;

class ActiveUsers implements WidgetsInterface
{

    protected $view = 'users::widgets.active';
    protected $permissions = ['users.*'];

    /**
     * Get the data to be passed on to the view
     *
     * @return mixed
     */
    public function data()
    {
        return ['active' => User::active()->count()];

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
