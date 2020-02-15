<?php

namespace App\Component\Book\Core\Factory;

use App\Component\Book\Core\Entity\Book;
use App\Infrastructure\Slugger\SluggerInterface;
use App\Infrastructure\Uuid\UuidInterface;

class BookFactory
{
    private UuidInterface $uuid;

    private SluggerInterface $slugger;

    public function __construct(UuidInterface $uuid, SluggerInterface $slugger)
    {
        $this->uuid = $uuid;
        $this->slugger = $slugger;
    }

    public function create(string $name): Book
    {
        return new Book(
            $this->uuid->generate(),
            $name,
            $this->slugger->slug($name)
        );
    }
}
