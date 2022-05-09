<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Suspend\Notification;

use DuRoom\Notification\Blueprint\BlueprintInterface;
use DuRoom\Notification\MailableInterface;
use DuRoom\User\User;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserSuspendedBlueprint implements BlueprintInterface, MailableInterface
{
    /**
     * @var User
     */
    public $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getFromUser()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->user->suspended_until;
    }

    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return 'userSuspended';
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubjectModel()
    {
        return User::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailView()
    {
        return ['text' => 'duroom-suspend::emails.suspended'];
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailSubject(TranslatorInterface $translator)
    {
        return $translator->trans('duroom-suspend.email.suspended.subject');
    }
}
