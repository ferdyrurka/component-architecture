<?php
declare(strict_types=1);

namespace App\Infrastructure\Microservices\Communication\Exception;

use Throwable;

class UnsuccessfulRequestException extends CommunicationException
{
    private string $response;

    public function __construct(string $message = '', ?string $response = null, $code = 0, Throwable $previous = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }
}
