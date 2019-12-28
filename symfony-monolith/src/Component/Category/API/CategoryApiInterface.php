<?php

namespace App\Component\Category\API;

use App\Component\Book\IO\BookIdInput;
use App\Component\Category\IO\CategoryIdInput;
use App\Component\Category\IO\CategoryIdOutput;
use App\Component\Category\IO\CategoryInput;

interface CategoryApiInterface
{
    public function addBook(BookIdInput $bookIdInput, CategoryIdInput $categoryIdInput): void;

    public function createCategory(CategoryInput $categoryInput): CategoryIdOutput;
}