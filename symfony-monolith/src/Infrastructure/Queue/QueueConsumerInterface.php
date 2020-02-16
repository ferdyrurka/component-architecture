<?php
declare(strict_types=1);

namespace App\Infrastructure\Queue;

use App\Infrastructure\Queue\Consumer\ConsumerHandlerInterface;

interface QueueConsumerInterface
{
    public function consume(string $eventName, ConsumerHandlerInterface $consumerHandler): void;
}
