<?php
declare(strict_types=1);

namespace App\Infrastructure\Microservices\Communication;

interface CommunicationInterface
{
    public function get(string $path): array;

    public function post(string $path, array $body = []): array;
}
