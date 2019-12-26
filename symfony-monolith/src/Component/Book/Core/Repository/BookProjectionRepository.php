<?php

namespace App\Component\Book\Core\Repository;

use App\Component\Book\Core\ReadModel\BookReadModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class BookProjectionRepository extends ServiceEntityRepository implements BookProjectionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookReadModel::class);
    }

    public function add(BookReadModel $bookReadModel): void
    {
        $this->getEntityManager()->persist($bookReadModel);
    }
}
