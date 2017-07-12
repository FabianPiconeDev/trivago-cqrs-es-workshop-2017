<?php declare(strict_types=1);

namespace Building\Infrastructure\Projector;

use Building\Domain\DomainEvent\UserWasCheckedIn;
use Building\Domain\DomainEvent\UserWasCheckedOut;
use Building\Infrastructure\Projector\CheckedInUserProjectionWriter;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Stream\StreamName;
use Rhumsaa\Uuid\Uuid;

final class CheckedInUserProjector
{
    private $eventStore;
    private $writer;

    public function __construct(EventStore $eventStore, CheckedInUserProjectionWriter $writer)
    {
        $this->eventStore = $eventStore;
        $this->writer = $writer;
    }

    public function project(AggregateChanged $event): void
    {
        $aggregateId = Uuid::fromString($event->aggregateId());
        $recordedEvents = $this->eventStore->loadEventsByMetadataFrom(
            new StreamName('event_stream'),
            [
                'aggregate_id' => $aggregateId,
            ]
        );

        $this->writer->write($aggregateId, $this->getCheckedInUsernames($recordedEvents));
    }

    private function getCheckedInUsernames(\Iterator $recordedEvents): array
    {
        $usernames = [];
        foreach ($recordedEvents as $recordedEvent) {
            if ($recordedEvent instanceof UserWasCheckedIn) {
                $usernames[$recordedEvent->username()] = null;
            }
            if ($recordedEvent instanceof UserWasCheckedOut) {
                unset($usernames[$recordedEvent->username()]);
            }
        }
        return array_keys($usernames);
    }
}