<?php
declare(strict_types=1);

namespace App\Component\Category\IO;

class CategoriesOutput
{
    private array $categories;

    public function __construct()
    {
        $this->categories = [];
    }

    public function addCategory(string $id, string $name): void
    {
        $this->categories[$name] = $id;
    }

    public function getArrayCategories(): array
    {
        return $this->categories;
    }
}
