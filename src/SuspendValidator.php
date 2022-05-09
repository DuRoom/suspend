<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Suspend;

use DuRoom\Foundation\AbstractValidator;

class SuspendValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'suspendedUntil' => ['nullable', 'date'],
    ];
}
