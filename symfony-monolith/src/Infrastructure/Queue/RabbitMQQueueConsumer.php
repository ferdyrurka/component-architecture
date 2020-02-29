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

    private RabbitMQQueueFactory $rabbitMQQueueFactory;

    private int $apiVersion;

    private string $exchangeName;

    public function __construct(
        RabbitMQQueueFactory $rabbitMQQueueFactory,
        string $exchangeName,
        int $apiVersion
    ) {
        $this->rabbitMQQueueFactory = $rabbitMQQueueFactory;
        $this->exchangeName = $exchangeName;
        $this->apiVersion = $apiVersion;
    }

    public function consume(string $eventName, ConsumerHandlerInterface $consumerHandler): void
    {
        $queueName = $this->rabbitMQQueueFactory->declaredQueue($eventName, $this->apiVersion);
        $this->rabbitMQQueueFactory->declaredDirectExchange($this->exchangeName);

        $channel = $this->rabbitMQQueueFactory->getChannel();

        $channel->queue_bind(
            $queueName,
            $this->exchangeName,
            NameFactory::getMonolithRoutingKey($this->apiVersion, $eventName)
        );

        $channel->basic_consume(
            $queueName,
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
}
