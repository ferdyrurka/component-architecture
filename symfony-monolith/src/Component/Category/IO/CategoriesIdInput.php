<?php

namespace App\Component\Category\IO;

class CategoriesIdInput
{
    /** @var string[]  */
    private array $categoriesId;

    public function __construct(array $categoriesId)
    {
        $this->categoriesId = $categoriesId;
    }

    public function getCategoriesId(): array
    {
        return $this->categoriesId;
    }
}
