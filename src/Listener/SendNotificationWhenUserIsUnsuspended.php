<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Suspend\Listener;

use DuRoom\Notification\NotificationSyncer;
use DuRoom\Suspend\Event\Unsuspended;
use DuRoom\Suspend\Notification\UserUnsuspendedBlueprint;

class SendNotificationWhenUserIsUnsuspended
{
    /**
     * @var NotificationSyncer
     */
    protected $notifications;

    /**
     * @param NotificationSyncer $notifications
     */
    public function __construct(NotificationSyncer $notifications)
    {
        $this->notifications = $notifications;
    }

    public function handle(Unsuspended $event)
    {
        $this->notifications->sync(
            new UserUnsuspendedBlueprint($event->user),
            [$event->user]
        );
    }
}
