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

namespace Ignite\Users\Events;

class UserHasBegunResetProcess {

    public $user;
    public $code;

    public function __construct($user, $code) {
        $this->user = $user;
        $this->code = $code;
    }

}
