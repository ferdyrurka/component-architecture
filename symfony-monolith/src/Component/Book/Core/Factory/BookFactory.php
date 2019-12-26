<?php

namespace App\Component\Book\Core\Factory;

use App\Component\Book\Core\Entity\Book;
use App\Infrastructure\Uuid\UuidInterface;

class BookFactory
{
    private UuidInterface $uuid;

    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function create(string $name, string $slug): Book
    {
        return new Book(
            $this->uuid->generate(),
            $name,
            $slug
        );
    }
}
