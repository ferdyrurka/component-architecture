<?php

namespace App\Component\Book\API;

use App\Component\Book\Core\UseCase\CreateBookApplicationService;
use App\Component\Book\IO\BookIdInput;
use App\Component\Book\IO\BookInput;
use App\Component\Category\API\CategoryApiInterface;
use App\Component\Category\IO\CategoryIdInput;

class BookApi implements BookApiInterface
{
    private CategoryApiInterface $categoryApi;

    private CreateBookApplicationService $createBookFacade;

    public function __construct(CategoryApiInterface $categoryApi, CreateBookApplicationService $createBookFacade)
    {
        $this->categoryApi = $categoryApi;
        $this->createBookFacade = $createBookFacade;
    }

    public function createBook(BookInput $bookInput): void
    {
        $bookIdInput = new BookIdInput($this->createBookFacade->create($bookInput->getName()));

        $this->categoryApi->addBook(
            $bookIdInput,
            new CategoryIdInput($bookInput->getCategoryId())
        );

        //TODO create read model event
    }
}
