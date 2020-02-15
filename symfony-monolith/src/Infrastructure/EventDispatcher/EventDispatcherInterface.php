<?php
declare(strict_types=1);

namespace App\Infrastructure\EventDispatcher;

interface EventDispatcherInterface
{
    public function dispatch(string $eventName, Event $event): void;
}
