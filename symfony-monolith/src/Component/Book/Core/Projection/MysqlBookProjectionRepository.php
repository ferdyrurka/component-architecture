<?php

namespace App\Component\Book\Core\Projection;

use App\Component\Book\Core\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

final class MysqlBookProjectionRepository extends ServiceEntityRepository implements BookProjectionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }
}
