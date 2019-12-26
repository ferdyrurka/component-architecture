<?php

namespace App\Component\Book\Core\Repository;

use App\Component\Book\Core\ReadModel\BookReadModel;

interface BookProjectionRepositoryInterface
{
    public function add(BookReadModel $bookReadModel): void;
}
