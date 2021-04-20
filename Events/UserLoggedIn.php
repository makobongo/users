<?php

namespace Ignite\Users\Events;

use Illuminate\Queue\SerializesModels;

class UserLoggedIn
{
    use SerializesModels;

    public $user, $request;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request, $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
