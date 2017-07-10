<?php declare(strict_types=1);

namespace Building\Domain\DomainEvent;

use Prooph\EventSourcing\AggregateChanged;

final class UserWasCheckedOut extends AggregateChanged
{
    public function username() : string
    {
        return $this->payload['username'];
    }
}
