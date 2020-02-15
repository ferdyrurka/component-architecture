<?php
declare(strict_types=1);

namespace App\Infrastructure\EventDispatcher\EventPublisher;

use App\Infrastructure\EventDispatcher\Event;

interface EventPublisherInterface
{
    public function publish(string $eventName, Event $event): void;
}
