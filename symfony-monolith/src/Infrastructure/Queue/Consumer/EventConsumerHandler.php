<?php
declare(strict_types=1);

namespace App\Infrastructure\Queue\Consumer;

use App\Infrastructure\EventDispatcher\Event;
use App\Infrastructure\EventDispatcher\EventDispatcherInterface;
use App\Infrastructure\Queue\Exception\RuntimeException;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Serializer\SerializerInterface;
use Exception;

class EventConsumerHandler implements ConsumerHandlerInterface
{
    private SerializerInterface $serializer;

    private EventDispatcherInterface $eventDispatcher;

    private ?string $eventClass = null;

    private ?string $eventName = null;

    public function __construct(
        SerializerInterface $serializer,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->serializer = $serializer;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function prepare(string $eventClass, string $eventName): void
    {
        $this->eventClass = $eventClass;
        $this->eventName = $eventName;
    }

    public function handle(AMQPMessage $message): void
    {
        /** @var AMQPChannel $channel */
        $channel = $message->delivery_info['channel'];
        $deliveryTag = $message->delivery_info['delivery_tag'];

        try {
            if ($this->eventClass === null || $this->eventName === null) {
                throw new RuntimeException(
                    'Event class and event name is required field!'
                );
            }

            /** @var Event $event */
            $event = $this->serializer->deserialize(
                $message->body,
                $this->eventClass,
                'json'
            );

            $this->eventDispatcher->dispatch($this->eventName, $event);

            $channel->basic_ack($deliveryTag);
        } catch (Exception $exception) {
            $channel->basic_nack($deliveryTag, false, true);

            //TODO: Add logger

            throw $exception;
        }
    }
}
