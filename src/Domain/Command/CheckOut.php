<?php declare(strict_types=1);

namespace Building\Domain\Command;

use Prooph\Common\Messaging\Command;
use Rhumsaa\Uuid\Uuid;

final class CheckOut extends Command
{
    private $username;
    private $buildingId;

    private function __construct(string $username, Uuid $buildingId)
    {
        $this->init();

        $this->username = $username;
        $this->buildingId = $buildingId;
    }

    public static function fromUserNameAndBuildingId(string $username, Uuid $buildingId): self
    {
        return new self($username, $buildingId);
    }

    public function username(): string
    {
        return $this->username;
    }

    public function buildingId(): Uuid
    {
        return $this->buildingId;
    }

    /**
     * {@inheritDoc}
     */
    public function payload(): array
    {
        return [
            'username' => $this->username,
            'buildingId' => $this->buildingId
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function setPayload(array $payload): void
    {
        $this->username = $payload['username'];
        $this->buildingId = $payload['buildingId'];
    }
}
