<?php
declare(strict_types=1);

namespace App\Infrastructure\Queue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
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

        $this->queueAndExchangeDeclare($channel, $eventName);
        $AMQPMessage = $this->createAMQPMessage($body);

        $channel->basic_publish($AMQPMessage, $this->exchange);
    }

    private function queueAndExchangeDeclare(AMQPChannel $channel, string $eventName): void
    {
        $channel->queue_declare(
            QueueNameFactory::getMonolithName($this->apiVersion, $eventName),
            false,
            true,
            false,
            false
        );
        $channel->exchange_declare(
            $this->exchange,
            AMQPExchangeType::DIRECT,
            false,
            true,
            false
        );
        $channel->queue_bind(QueueNameFactory::getMonolithName($this->apiVersion, $eventName), $this->exchange);
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
