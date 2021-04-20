<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Users\Events\Handlers;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Ignite\Users\Events\UserHasRegistered;

class SendRegistrationConfirmationEmail
{

    public function handle(UserHasRegistered $event) {
        $user = $event->user;

        $data = [
            'user' => $user,
            'activationcode' => md5(str_random(20)),
        ];

        Mail::queue('users::emails.welcome', $data, function (Message $m) use ($user) {
            $m->to($user->email)->subject('Welcome.');
        });
    }

}
