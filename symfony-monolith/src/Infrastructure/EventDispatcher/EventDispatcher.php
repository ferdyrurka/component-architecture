<?php
declare(strict_types=1);

namespace App\Infrastructure\EventDispatcher;

use App\Infrastructure\EventDispatcher\EventPublisher\EventPublisherInterface;

final class EventDispatcher implements EventDispatcherInterface
{
    private array $publishers;

    public function __construct(EventPublisherInterface ...$publishers)
    {
        $this->publishers = $publishers;
    }

    public function dispatch(string $eventName, Event $event): void
    {
        foreach ($this->publishers as $publisher) {
            $publisher->publish($eventName, $event);
        }
    }
}
