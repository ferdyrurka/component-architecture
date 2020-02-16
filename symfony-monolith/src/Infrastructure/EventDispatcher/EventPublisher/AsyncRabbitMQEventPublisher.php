<?php
declare(strict_types=1);

namespace App\Infrastructure\EventDispatcher\EventPublisher;

use App\Infrastructure\EventDispatcher\Event;
use App\Infrastructure\Queue\QueuePublisherInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AsyncRabbitMQEventPublisher implements EventPublisherInterface
{
    private QueuePublisherInterface $queue;

    private SerializerInterface $serializer;

    public function __construct(QueuePublisherInterface $queue, SerializerInterface $serializer)
    {
        $this->queue = $queue;
        $this->serializer = $serializer;
    }

    public function publish(string $eventName, Event $event): void
    {
        $this->queue->publishEvent(
            sprintf('%s_%s', $eventName, EventPrefix::ASYNC_RABBIT_MQ_PREFIX()->getValue()),
            $this->serializer->serialize($event, 'json')
        );
    }
}
