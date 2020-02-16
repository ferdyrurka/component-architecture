<?php
declare(strict_types=1);

namespace App\Infrastructure\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQQueuePublisher implements QueuePublisherInterface
{
    private AMQPStreamConnection $amqpStreamConnection;

    private int $apiVersion;

    private string $exchange;

    public function __construct(
        AMQPStreamConnection $amqpStreamConnection,
        string $exchange,
        int $apiVersion
    ) {
        $this->amqpStreamConnection = $amqpStreamConnection;
        $this->exchange = $exchange;
        $this->apiVersion = $apiVersion;
    }

    public function publishEvent(string $eventName, string $body): void
    {
        $channel = $this->amqpStreamConnection->channel();

        $AMQPMessage = $this->createAMQPMessage($body);

        $channel->basic_publish(
            $AMQPMessage,
            $this->exchange,
            QueueFactory::getMonolithRoutingKey($this->apiVersion, $eventName)
        );
    }

    private function createAMQPMessage(string $body): AMQPMessage
    {
        return new AMQPMessage(
            $body,
            [
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            ]
        );
    }
}
