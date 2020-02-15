<?php

namespace App\Component\Book\Core\UseCase;

use App\Component\Book\Core\Factory\BookFactory;
use App\Component\Book\Core\Repository\BookRepositoryInterface;
use App\Component\Book\IO\BookInput;
use App\Infrastructure\EventDispatcher\EventDispatcherInterface;
use App\Infrastructure\UnityOfWork\UnityOfWorkInterface;

final class CreateBookApplicationService
{
    private BookFactory $bookFactory;

    private BookRepositoryInterface $bookRepository;

    private UnityOfWorkInterface $unityOfWork;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        BookFactory $bookFactory,
        BookRepositoryInterface $bookRepository,
        UnityOfWorkInterface $unityOfWork,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->bookFactory = $bookFactory;
        $this->bookRepository = $bookRepository;
        $this->unityOfWork = $unityOfWork;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function create(BookInput $bookInput): string
    {
        $book = $this->bookFactory->create($bookInput->getName());

        $this->bookRepository->add($book);
        $this->unityOfWork->commit();

        return $book->getId();
    }
}
