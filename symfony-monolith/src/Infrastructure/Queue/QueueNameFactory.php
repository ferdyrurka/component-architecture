<?php
declare(strict_types=1);

namespace App\Infrastructure\Queue;

class QueueNameFactory
{
    private const MONOLITH_QUEUE_PREFIX = 'symfony_monolith';

    public static function getMonolithName(int $apiVersion, string $name): string
    {
        return sprintf('%s_v%d_%s', self::MONOLITH_QUEUE_PREFIX, $apiVersion, $name);
    }
}
