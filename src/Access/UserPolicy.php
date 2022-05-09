<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Suspend\Access;

use DuRoom\User\Access\AbstractPolicy;
use DuRoom\User\User;

class UserPolicy extends AbstractPolicy
{
    /**
     * @param User $actor
     * @param User $user
     * @return bool|null
     */
    public function suspend(User $actor, User $user)
    {
        if ($user->isAdmin() || $user->id === $actor->id) {
            return $this->deny();
        }
    }
}
