<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use DuRoom\Api\Serializer\BasicUserSerializer;
use DuRoom\Api\Serializer\UserSerializer;
use DuRoom\Extend;
use DuRoom\Suspend\Access\UserPolicy;
use DuRoom\Suspend\AddUserSuspendAttributes;
use DuRoom\Suspend\Event\Suspended;
use DuRoom\Suspend\Event\Unsuspended;
use DuRoom\Suspend\Listener;
use DuRoom\Suspend\Notification\UserSuspendedBlueprint;
use DuRoom\Suspend\Notification\UserUnsuspendedBlueprint;
use DuRoom\Suspend\Query\SuspendedFilterGambit;
use DuRoom\Suspend\RevokeAccessFromSuspendedUsers;
use DuRoom\User\Event\Saving;
use DuRoom\User\Filter\UserFilterer;
use DuRoom\User\Search\UserSearcher;
use DuRoom\User\User;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/less/admin.less'),

    (new Extend\Model(User::class))
        ->dateAttribute('suspended_until'),

    (new Extend\ApiSerializer(UserSerializer::class))
        ->attributes(AddUserSuspendAttributes::class),

    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Notification())
        ->type(UserSuspendedBlueprint::class, BasicUserSerializer::class, ['alert', 'email'])
        ->type(UserUnsuspendedBlueprint::class, BasicUserSerializer::class, ['alert', 'email']),

    (new Extend\Event())
        ->listen(Saving::class, Listener\SaveSuspensionToDatabase::class)
        ->listen(Suspended::class, Listener\SendNotificationWhenUserIsSuspended::class)
        ->listen(Unsuspended::class, Listener\SendNotificationWhenUserIsUnsuspended::class),

    (new Extend\Policy())
        ->modelPolicy(User::class, UserPolicy::class),

    (new Extend\User())
        ->permissionGroups(RevokeAccessFromSuspendedUsers::class),

    (new Extend\Filter(UserFilterer::class))
        ->addFilter(SuspendedFilterGambit::class),

    (new Extend\SimpleDuRoomSearch(UserSearcher::class))
        ->addGambit(SuspendedFilterGambit::class),

    (new Extend\View())
        ->namespace('duroom-suspend', __DIR__.'/views'),
];
