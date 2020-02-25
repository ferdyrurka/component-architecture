<?php

namespace App\Component\Category\API;

use App\Component\Book\IO\BookIdInput;
use App\Component\Category\IO\CategoriesIdsInput;
use App\Component\Category\IO\CategoriesOutput;
use App\Component\Category\IO\CategoryIdOutput;
use App\Component\Category\IO\CategoryInput;

interface CategoryApiInterface
{
    public function addBookToCategory(BookIdInput $bookIdInput, CategoriesIdsInput $categoriesIdsInput): void;

    public function createCategory(CategoryInput $categoryInput): CategoryIdOutput;

    public function findAll(): CategoriesOutput;
}