<?php declare(strict_types=1);

namespace Building\Infrastructure\Projector;

use Rhumsaa\Uuid\Uuid;

final class CheckedInUserProjectionWriter
{
    public function write(Uuid $aggregateId, array $usernames): void
    {
        $folder = __DIR__ . '/../../../public/data/building/dump/';
        if (!is_dir($folder)) {
            mkdir($folder, 0775, true);
        }
        file_put_contents(
            $folder . 'building-dump-' . $aggregateId->toString() . '.json',
            json_encode($usernames)
        );
    }
}