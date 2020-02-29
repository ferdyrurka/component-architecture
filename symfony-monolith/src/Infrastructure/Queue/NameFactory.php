<?php
declare(strict_types=1);

namespace App\Infrastructure\Queue;

class NameFactory
{
    private const MONOLITH_QUEUE_PREFIX = 'monolith';

    public static function getMonolithQueueName(int $apiVersion, string $name): string
    {
        return sprintf('%s_v%d_%s', self::MONOLITH_QUEUE_PREFIX, $apiVersion, $name);
    }

    public static function getMonolithRoutingKey(int $apiVersion, string $name): string
    {
        return sprintf('%s_v%d_routing_key_%s', self::MONOLITH_QUEUE_PREFIX, $apiVersion, $name);
    }
}
