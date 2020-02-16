<?php
declare(strict_types=1);

namespace App\Infrastructure\EventDispatcher\EventPublisher;

use App\Infrastructure\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SyncSymfonyEventPublisher implements EventPublisherInterface
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function publish(string $eventName, Event $event): void
    {
        $this->eventDispatcher->dispatch(
            $event,
            sprintf(
                '%s_%s',
                $eventName,
                EventPrefix::SYNC_SYMFONY_PREFIX()->getValue()
            )
        );
    }
}
