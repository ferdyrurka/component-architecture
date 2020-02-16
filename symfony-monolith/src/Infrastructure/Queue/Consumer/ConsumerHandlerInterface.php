<?php
declare(strict_types=1);

namespace App\Infrastructure\Queue\Consumer;

use PhpAmqpLib\Message\AMQPMessage;

interface ConsumerHandlerInterface
{
    public function handle(AMQPMessage $message): void;
}
