<?php
declare(strict_types=1);

namespace App\Component\Book\IO;

class BookInput
{
    private string $name;

    private array $categoryIds;

    public function __construct(string $name = '', array $categoryIds = [])
    {
        $this->name        = $name;
        $this->categoryIds = $categoryIds;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }
}
