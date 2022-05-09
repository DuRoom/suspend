<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Suspend\Event;

use DuRoom\User\User;

class Suspended
{
    /**
     * @var User
     */
    public $user;
    /**
     * @var User
     */
    public $actor;

    public function __construct(User $user, User $actor)
    {
        $this->user = $user;
        $this->actor = $actor;
    }
}
