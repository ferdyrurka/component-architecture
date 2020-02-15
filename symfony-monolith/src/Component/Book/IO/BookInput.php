<?php
declare(strict_types=1);

namespace App\Component\Book\IO;

class BookInput
{
    private string $name;

    private array $categoriesId;

    public function __construct(string $name, array $categoriesId)
    {
        $this->name = $name;
        $this->categoriesId = $categoriesId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCategoriesId(): array
    {
        return $this->categoriesId;
    }

    public function setCategoriesId(array $categoriesId): void
    {
        $this->categoriesId = $categoriesId;
    }
}
