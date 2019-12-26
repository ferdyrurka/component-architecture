<?php

namespace App\Infrastructure\Uuid;

interface UuidInterface
{
    public function generate(): string;
}
