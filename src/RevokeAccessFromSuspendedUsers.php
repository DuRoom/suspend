<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Suspend;

use Carbon\Carbon;
use DuRoom\Group\Group;
use DuRoom\User\User;

class RevokeAccessFromSuspendedUsers
{
    /**
     * @param User $user
     * @param array $groupIds
     */
    public function __invoke(User $user, array $groupIds)
    {
        $suspendedUntil = $user->suspended_until;

        if ($suspendedUntil && $suspendedUntil->gt(Carbon::now())) {
            return [Group::GUEST_ID];
        }

        return $groupIds;
    }
}
