<?php

namespace App\Component\Book\Core\Repository;

use App\Component\Book\Core\Entity\Book;

interface BookRepositoryInterface
{
    public function add(Book $book): void;
}
