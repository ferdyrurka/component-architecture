<?php
declare(strict_types=1);

namespace App\Infrastructure\Queue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class RabbitMQQueueFactory
{
    private AMQPStreamConnection $amqpStreamConnection;

    public function __construct(AMQPStreamConnection $amqpStreamConnection)
    {
        $this->amqpStreamConnection = $amqpStreamConnection;
    }

    public function getChannel(): AMQPChannel
    {
        return $this->amqpStreamConnection->channel();
    }

    public function declaredQueue(string $eventName, int $apiVersion): string
    {
        $queueName = NameFactory::getMonolithQueueName($apiVersion, $eventName);

        $this->getChannel()->queue_declare(
            $queueName,
            false,
            true,
            false,
            false
        );

        return $queueName;
    }

    public function declaredDirectExchange(string $exchangeName): void
    {
        $this->getChannel()->exchange_declare(
            $exchangeName,
            AMQPExchangeType::DIRECT,
            false,
            true,
            false
        );
    }
}
