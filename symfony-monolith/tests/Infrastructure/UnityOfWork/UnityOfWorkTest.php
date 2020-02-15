<?php
declare(strict_types=1);

namespace App\Tests\Infrastructure\UnityOfWork;

use App\Infrastructure\UnityOfWork\UnityOfWork;
use App\Infrastructure\UnityOfWork\UnityOfWorkInterface;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Doctrine\DBAL\ConnectionException;

class UnityOfWorkTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private EntityManagerInterface $entityManager;

    private UnityOfWorkInterface $unityOfWork;

    protected function setUp(): void
    {
        $this->entityManager = Mockery::mock(EntityManagerInterface::class);

        $this->unityOfWork = new UnityOfWork($this->entityManager);
    }

    /**
     * @throws ConnectionException
     * @test
     */
    public function commitWithException(): void
    {
        $this->entityManager->shouldReceive('beginTransaction')->once();
        $this->entityManager->shouldReceive('flush')->once()
            ->andThrow(ConnectionException::class)
        ;

        $connection = Mockery::mock(Connection::class);
        $connection->shouldReceive('rollback')->once();

        $this->entityManager->shouldReceive('getConnection')->once()
            ->andReturn($connection)
        ;
        $this->entityManager->shouldReceive('close')->once();

        $this->expectException(ConnectionException::class);
        $this->unityOfWork->commit();
    }

    /**
     * @throws ConnectionException
     * @test
     */
    public function commitOk(): void
    {
        $this->entityManager->shouldReceive('beginTransaction')->once();

        $this->entityManager->shouldReceive('flush')->once();

        $connection = Mockery::mock(Connection::class);
        $connection->shouldReceive('commit')->once();

        $this->entityManager->shouldReceive('getConnection')->once()
            ->andReturn($connection)
        ;

        $this->unityOfWork->commit();
    }
}
