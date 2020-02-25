<?php

namespace App\Component\Book\Core\Repository;

use App\Component\Book\Core\Entity\Book;

interface BookRepositoryInterface
{
    public function add(Book $book): void;

    public function getById(int $id): Book;

    public function remove(Book $book): void;
}
