<?php
declare(strict_types=1);

namespace App\Component\Book\API;

use App\Component\Book\IO\BookInput;

interface BookApiInterface
{
    public function createBook(BookInput $bookInput): void;
}
