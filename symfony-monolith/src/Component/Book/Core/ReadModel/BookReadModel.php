<?php

namespace App\Component\Book\Core\ReadModel;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="book_read_model")
 * @ORM\Entity()
 */
class BookReadModel
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private string $bookId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private string $categoryName;

    public function __construct(string $bookId, string $name, string $slug, string $categoryName)
    {
        $this->bookId = $bookId;
        $this->name = $name;
        $this->slug = $slug;
        $this->categoryName = $categoryName;
    }

    public function getBookId(): string
    {
        return $this->bookId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
    }
}
