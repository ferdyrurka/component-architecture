<?php

namespace App\Component\Book\Core\UseCase;

use App\Component\Book\Core\Factory\BookFactory;
use App\Component\Book\Core\Repository\BookRepositoryInterface;
use App\Infrastructure\Slugger\SluggerInterface;
use App\Infrastructure\UnityOfWork\UnityOfWorkInterface;

class CreateBookApplicationService
{
    private BookFactory $bookFactory;

    private BookRepositoryInterface $bookRepository;

    private UnityOfWorkInterface $unityOfWork;

    private SluggerInterface $slugger;

    public function __construct(
        BookFactory $bookFactory,
        BookRepositoryInterface $bookRepository,
        UnityOfWorkInterface $unityOfWork,
        SluggerInterface $slugger
    ) {
        $this->bookFactory = $bookFactory;
        $this->bookRepository = $bookRepository;
        $this->unityOfWork = $unityOfWork;
        $this->slugger = $slugger;
    }

    public function create(string $name): string
    {
        $book = $this->bookFactory->create(
            $name,
            $this->slugger->slug($name)
        );

        $this->bookRepository->add($book);
        $this->unityOfWork->commit();

        return $book->getId();
    }
}
