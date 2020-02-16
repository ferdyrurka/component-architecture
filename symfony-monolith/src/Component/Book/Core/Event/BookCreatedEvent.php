<?php
declare(strict_types=1);

namespace App\Component\Book\Core\Event;

use App\Infrastructure\EventDispatcher\Event;

class BookCreatedEvent extends Event
{
    private string $bookId;

    public function __construct(string $bookId)
    {
        $this->bookId = $bookId;
    }

    public function getBookId(): string
    {
        return $this->bookId;
    }
}
