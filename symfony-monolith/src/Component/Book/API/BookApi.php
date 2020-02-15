<?php

namespace App\Component\Book\API;

use App\Component\Book\Core\UseCase\CreateBookApplicationService;
use App\Component\Book\IO\BookInput;
use App\Component\Category\API\CategoryApiInterface;

final class BookApi implements BookApiInterface
{
    private CategoryApiInterface $categoryApi;

    private CreateBookApplicationService $createBookApplicationService;

    public function __construct(
        CategoryApiInterface $categoryApi,
        CreateBookApplicationService $createBookApplicationService
    ) {
        $this->categoryApi = $categoryApi;
        $this->createBookApplicationService = $createBookApplicationService;
    }

    public function createBook(BookInput $bookInput): void
    {
        $bookId = $this->createBookApplicationService->create($bookInput);
    }
}
