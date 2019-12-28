<?php
declare(strict_types=1);

namespace App\Component\Book\IO;

class BookInput
{
    private string $name;

    private string $categoryId;

    public function __construct(string $name, string $categoryId)
    {
        $this->name = $name;
        $this->categoryId = $categoryId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function setCategoryId(string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }
}
