<?php
declare(strict_types=1);

namespace App\Tests\Infrastructure\EventDispatcher;

use App\Infrastructure\EventDispatcher\Event;
use App\Infrastructure\EventDispatcher\EventDispatcher;
use App\Infrastructure\EventDispatcher\EventPublisher\EventPublisherInterface;
use PHPUnit\Framework\TestCase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class EventDispatcherTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @test
     */
    public function dispatchSingleOk(): void
    {
        $publisher = Mockery::mock(EventPublisherInterface::class);
        $publisher->shouldReceive('publish')->once();

        $dispatcher = new EventDispatcher($publisher);
        $dispatcher->dispatch('test', Mockery::mock(Event::class));
    }

    /**
     * @test
     */
    public function dispatchMultiOk(): void
    {
        $publisher1 = Mockery::mock(EventPublisherInterface::class);
        $publisher1->shouldReceive('publish')->times(2);

        $publisher2 = clone $publisher1;

        $dispatcher = new EventDispatcher($publisher1, $publisher2);
        $dispatcher->dispatch('test', Mockery::mock(Event::class));
    }
}
