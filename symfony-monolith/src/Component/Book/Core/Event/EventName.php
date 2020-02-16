<?php
declare(strict_types=1);

namespace App\Component\Book\Core\Event;

use MyCLabs\Enum\Enum;

/**
 * @method static EventName BOOK_CREATED_EVENT()
 */
class EventName extends Enum
{
    public const BOOK_CREATED_EVENT = 'book_created';
}
