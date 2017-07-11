<?php declare(strict_types=1);

namespace Building\Infrastructure;

final class CommandLineWriter
{
    public function writeStderr(string $message): void
    {
        fwrite(fopen('php://stderr', 'w'), $message . PHP_EOL);
    }
}