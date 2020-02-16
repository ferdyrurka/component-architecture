<?php
declare(strict_types=1);

namespace App\Infrastructure\Queue;

use App\Infrastructure\Queue\Consumer\ConsumerHandlerInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class RabbitMQQueueConsumer implements QueueConsumerInterface
{
    private const CONSUMER_TAG = 'symfony_monolith_consumer';

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

    public function consume(string $eventName, ConsumerHandlerInterface $consumerHandler): void
    {
        $channel = $this->amqpStreamConnection->channel();

        $this->declaredQueueAndExchange($eventName, $channel);

        $channel->basic_consume(
            QueueFactory::getMonolithQueueName($this->apiVersion, $eventName),
            self::CONSUMER_TAG,
            false,
            false,
            false,
            false,
            [$consumerHandler, 'handle']
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    private function declaredQueueAndExchange(string $eventName, AMQPChannel $channel): void
    {
        $queueName = QueueFactory::getMonolithQueueName($this->apiVersion, $eventName);

        $channel->queue_declare(
            $queueName,
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
        $channel->queue_bind(
            $queueName,
            $this->exchange,
            QueueFactory::getMonolithRoutingKey($this->apiVersion, $eventName)
        );
    }
}
