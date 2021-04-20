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
use Ignite\Users\Events\UserHasBegunResetProcess;

class SendResetCodeEmail {

    public function handle(UserHasBegunResetProcess $event) {
        $user = $event->user;
        $code = $event->code;

        Mail::queue('user::emails.reminder', compact('user', 'code'), function (Message $m) use ($user) {
            $m->to($user->email)->subject('Reset your account password.');
        });
    }

}
