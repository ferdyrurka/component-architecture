<?php
declare(strict_types=1);

namespace App\Component\Book\IO;

class BookInput
{
    private string $name;

    private array $categoriesIds;

    public function __construct(string $name, array $categoriesIds)
    {
        $this->name = $name;
        $this->categoriesIds = $categoriesIds;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCategoriesIds(): array
    {
        return $this->categoriesIds;
    }

    public function setCategoriesIds(array $categoriesIds): void
    {
        $this->categoriesIds = $categoriesIds;
    }
}
