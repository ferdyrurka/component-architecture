<?php

namespace App\Infrastructure\Slugger;

use Symfony\Component\String\Slugger\AsciiSlugger;

class Slugger implements SluggerInterface
{
    private AsciiSlugger $slugger;

    public function __construct(AsciiSlugger $slugger)
    {
        $this->slugger = $slugger;
    }

    public function slug(string $value): string
    {
        return $this->slugger->slug($value);
    }
}
