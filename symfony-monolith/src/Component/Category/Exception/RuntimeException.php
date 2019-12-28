<?php
declare(strict_types=1);

namespace App\Component\Category\Exception;

use Throwable;

class RuntimeException extends CategoryApiException
{
    public function __construct(
        string $action,
        string $endpointName,
        string $message,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            sprintf(
                'RuntimeException in category component! Action: %s , Uri: %s , Message: %s',
                $action,
                $endpointName,
                $message
            ),
            $code,
            $previous
        );
    }
}
