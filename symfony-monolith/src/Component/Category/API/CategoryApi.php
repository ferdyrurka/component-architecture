<?php
declare(strict_types=1);

namespace App\Component\Category\API;

use App\Component\Book\IO\BookIdInput;
use App\Component\Category\IO\CategoryIdInput;

class CategoryApi implements CategoryApiInterface
{
    public function addBook(BookIdInput $bookIdInput, CategoryIdInput $categoryIdInput): void
    {

    }
}
