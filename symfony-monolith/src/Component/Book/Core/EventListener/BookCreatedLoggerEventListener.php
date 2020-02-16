<?php
declare(strict_types=1);

namespace App\Component\Book\Core\EventListener;

use App\Component\Book\Core\Event\BookCreatedEvent;
use Psr\Log\LoggerInterface;

class BookCreatedLoggerEventListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function syncLog(BookCreatedEvent $event): void
    {
        $this->logger->notice(
            sprintf('Sync book created with id: %s', $event->getBookId())
        );
    }

    public function asyncLog(BookCreatedEvent $event): void
    {
        $this->logger->notice(
            sprintf('Async book created with id: %s', $event->getBookId())
        );
    }
}
