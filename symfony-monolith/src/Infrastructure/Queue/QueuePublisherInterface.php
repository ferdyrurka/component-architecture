<?php
declare(strict_types=1);

namespace App\Infrastructure\Queue;

interface QueuePublisherInterface
{
    public function publishEvent(string $eventName, string $body): void;
}
