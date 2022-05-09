<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Suspend\Query;

use Carbon\Carbon;
use DuRoom\Filter\FilterInterface;
use DuRoom\Filter\FilterState;
use DuRoom\Search\AbstractRegexGambit;
use DuRoom\Search\SearchState;
use DuRoom\User\Guest;
use DuRoom\User\UserRepository;
use Illuminate\Database\Query\Builder;

class SuspendedFilterGambit extends AbstractRegexGambit implements FilterInterface
{
    /**
     * @var \DuRoom\User\UserRepository
     */
    protected $users;

    /**
     * @param \DuRoom\User\UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    protected function getGambitPattern()
    {
        return 'is:suspended';
    }

    /**
     * {@inheritdoc}
     */
    public function apply(SearchState $search, $bit)
    {
        if (! $search->getActor()->can('suspend', new Guest())) {
            return false;
        }

        return parent::apply($search, $bit);
    }

    /**
     * {@inheritdoc}
     */
    protected function conditions(SearchState $search, array $matches, $negate)
    {
        $this->constrain($search->getQuery(), $negate);
    }

    public function getFilterKey(): string
    {
        return 'suspended';
    }

    public function filter(FilterState $filterState, string $filterValue, bool $negate)
    {
        if (! $filterState->getActor()->can('suspend', new Guest())) {
            return false;
        }

        $this->constrain($filterState->getQuery(), $negate);
    }

    protected function constrain(Builder $query, bool $negate)
    {
        $query->where(function ($query) use ($negate) {
            if ($negate) {
                $query->where('suspended_until', null)->orWhere('suspended_until', '<', Carbon::now());
            } else {
                $query->where('suspended_until', '>', Carbon::now());
            }
        });
    }
}
