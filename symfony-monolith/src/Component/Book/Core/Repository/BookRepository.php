<?php

namespace App\Component\Book\Core\Repository;

use App\Component\Book\Core\Entity\Book;
use App\Component\Book\Core\Exception\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

final class BookRepository extends ServiceEntityRepository implements BookRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function add(Book $book): void
    {
        $this->getEntityManager()->persist($book);
    }

    public function getById(int $id): Book
    {
        /** @var Book|null $book */
        $book = $this->find($id);

        if ($book === null) {
            throw new NotFoundException('Book not found');
        }

        return $book;
    }
}
