<?php

declare(strict_types=1);

namespace Building\Domain\Aggregate;

use Building\Domain\DomainEvent\NewBuildingWasRegistered;
use Building\Domain\DomainEvent\UserWasCheckedIn;
use Building\Domain\DomainEvent\UserWasCheckedOut;
use Prooph\EventSourcing\AggregateRoot;
use Rhumsaa\Uuid\Uuid;

final class Building extends AggregateRoot
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @var string
     */
    private $name;
    private $checkedInUsers;

    public static function new(string $name) : self
    {
        $self = new self();

        $self->recordThat(NewBuildingWasRegistered::occur(
            (string) Uuid::uuid4(),
            [
                'name' => $name
            ]
        ));

        return $self;
    }

    public function checkInUser(string $username): void
    {
        if(array_key_exists($username, $this->checkedInUsers)) {
            throw new \DomainException('User is already checked in.');
        }
        $this->recordThat(UserWasCheckedIn::occur(
            $this->uuid->toString(),
            [
                'username' => $username
            ]
        ));
    }

    public function checkOutUser(string $username): void
    {
        if(!array_key_exists($username, $this->checkedInUsers)) {
            throw new \DomainException('User was not checked in.');
        }
        $this->recordThat(UserWasCheckedOut::occur(
            $this->uuid->toString(),
            [
                'username' => $username
            ]
        ));
    }

    public function whenNewBuildingWasRegistered(NewBuildingWasRegistered $event): void
    {
        $this->uuid = $event->uuid();
        $this->name = $event->name();
    }

    public function whenUserWasCheckedIn(UserWasCheckedIn $event): void
    {
        $this->checkedInUsers[$event->username()] = null;
    }

    public function whenUserWasCheckedOut(UserWasCheckedOut $event): void
    {
        unset($this->checkedInUsers[$event->username()]);
    }

    /**
     * {@inheritDoc}
     */
    protected function aggregateId() : string
    {
        return (string) $this->uuid;
    }

    /**
     * {@inheritDoc}
     */
    public function id() : string
    {
        return $this->aggregateId();
    }
}
