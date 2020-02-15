<?php
declare(strict_types=1);

namespace App\Infrastructure\EventDispatcher\EventPublisher;

use App\Infrastructure\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

class SyncSymfonyEventPublisher extends EventDispatcher implements EventPublisherInterface
{
    public function publish(string $eventName, Event $event): void
    {
        $this->dispatch($event, $eventName);
    }
}
