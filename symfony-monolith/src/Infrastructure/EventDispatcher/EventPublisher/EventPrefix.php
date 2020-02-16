<?php
declare(strict_types=1);

namespace App\Infrastructure\EventDispatcher\EventPublisher;

use MyCLabs\Enum\Enum;

/**
 * @method static EventPrefix ASYNC_RABBIT_MQ_PREFIX()
 * @method static EventPrefix SYNC_SYMFONY_PREFIX()
 */
class EventPrefix extends Enum
{
    public const ASYNC_RABBIT_MQ_PREFIX = 'async';

    public const SYNC_SYMFONY_PREFIX = 'sync';
}
