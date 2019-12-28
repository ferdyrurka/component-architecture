<?php
declare(strict_types=1);

namespace App\Component\Category\Exception;

use Throwable;

class CategoryWasFoundException extends CategoryApiException
{
    public function __construct(string $categoryName = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Category was found for name: %s', $categoryName),
            $code,
            $previous
        );
    }
}
