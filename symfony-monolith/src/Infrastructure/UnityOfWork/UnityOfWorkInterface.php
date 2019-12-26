<?php

namespace App\Infrastructure\UnityOfWork;

interface UnityOfWorkInterface
{
    public function commit(): void;

    public function clear(): void;

    public function rollback(): void;
}
