<?php
declare(strict_types=1);

namespace App\UI\CLI;

use App\Infrastructure\Queue\Consumer\EventConsumerHandler;
use App\Infrastructure\Queue\QueueConsumerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EventQueueCommand extends Command
{
    private QueueConsumerInterface $queueConsumer;

    private EventConsumerHandler $eventConsumerHandler;

    public function __construct(
        QueueConsumerInterface $queueConsumer,
        EventConsumerHandler $eventConsumerHandler
    ) {
        $this->queueConsumer = $queueConsumer;
        $this->eventConsumerHandler = $eventConsumerHandler;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('queue:consumer:event');
        $this->addArgument('name', InputArgument::REQUIRED, 'Event name');
        $this->addArgument('event', InputArgument::REQUIRED, 'Event class');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $eventName = $input->getArgument('name');

        $this->eventConsumerHandler->prepare(
            $input->getArgument('event'),
            $eventName
        );

        $this->queueConsumer->consume(
            $eventName,
            $this->eventConsumerHandler
        );
    }
}
