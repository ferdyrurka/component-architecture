<?php

namespace App\Infrastructure\Uuid;

use Ramsey\Uuid\Uuid as BaseUuid;

class Uuid implements UuidInterface
{
    public function generate(): string
    {
        return BaseUuid::uuid4()->toString();
    }
}
