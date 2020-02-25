<?php

namespace App\Component\Category\IO;

class CategoriesIdsInput
{
    /** @var string[]  */
    private array $categoriesIds;

    public function __construct(array $categoriesIds)
    {
        $this->categoriesIds = $categoriesIds;
    }

    public function getCategoriesIds(): array
    {
        return $this->categoriesIds;
    }
}
