<?php

namespace App\Component\Category\API;

use App\Component\Book\IO\BookIdInput;
use App\Component\Category\IO\CategoriesIdInput;
use App\Component\Category\IO\CategoriesOutput;
use App\Component\Category\IO\CategoryIdOutput;
use App\Component\Category\IO\CategoryInput;

interface CategoryApiInterface
{
    public function addBook(BookIdInput $bookIdInput, CategoriesIdInput $categoriesIdInput): void;

    public function createCategory(CategoryInput $categoryInput): CategoryIdOutput;

    public function findAll(): CategoriesOutput;
}