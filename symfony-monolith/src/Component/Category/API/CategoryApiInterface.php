<?php

namespace App\Component\Category\API;

use App\Component\Book\IO\BookIdInput;
use App\Component\Category\IO\CategoryIdInput;

interface CategoryApiInterface
{
    public function addBook(BookIdInput $bookIdInput, CategoryIdInput $categoryIdInput): void;
}