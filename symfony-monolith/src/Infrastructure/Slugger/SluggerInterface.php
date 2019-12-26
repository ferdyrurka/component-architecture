<?php

namespace App\Infrastructure\Slugger;

interface SluggerInterface
{
    public function slug(string $value): string;
}