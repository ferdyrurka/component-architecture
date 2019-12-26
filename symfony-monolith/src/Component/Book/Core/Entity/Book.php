<?php
declare(strict_types=1);

namespace App\Component\Book\Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="book")
 * @ORM\Entity()
 */
class Book
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private string $id;

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

    public function __construct(string $id, string $name, string $slug)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
