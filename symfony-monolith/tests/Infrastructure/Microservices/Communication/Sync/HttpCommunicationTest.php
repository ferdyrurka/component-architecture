<?php
declare(strict_types=1);

namespace App\Tests\Unit\Infrsastructure\Microservice\Communication\Sync;

use App\Infrastructure\Microservices\Communication\Exception\UnsuccessfulRequestException;
use App\Infrastructure\Microservices\Communication\Sync\HttpCommunication;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Mockery;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpCommunicationTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    private const USER_AGENT = 'Symfony Monolith';

    private const DOMAIN = 'https://lukaszstaniszewski.pl';

    private const API_VERSION = 1;

    private const VALID_API_URL = self::DOMAIN . '/api/v' . self::API_VERSION;

    private HttpCommunication $httpCommunication;

    private HttpClientInterface $httpClient;

    protected function setUp(): void
    {
        $this->httpClient = Mockery::mock(HttpClientInterface::class);
        $this->httpCommunication = new HttpCommunication($this->httpClient, self::DOMAIN, self::API_VERSION);
    }

    /**
     * @param string $method
     *
     * @test
     * @dataProvider getMethods
     */
    public function codeDifferentHttp200Code(string $method): void
    {
        $responseInterface = Mockery::mock(ResponseInterface::class);
        $responseInterface->shouldReceive('getStatusCode')->once()->andReturn(201);
        $responseInterface->shouldReceive('getInfo')->once()->andReturn(['url' => 'test']);
        $responseInterface->shouldReceive('getContent')->once()->andReturn('content');

        $this->httpClient->shouldReceive('request')->once()->andReturn($responseInterface);

        $this->expectException(UnsuccessfulRequestException::class);
        $this->httpCommunication->$method('create');
    }

    /**
     * @param string $method
     *
     * @test
     * @dataProvider getMethods
     */
    public function requestOk(string $method): void
    {
        $responseInterface = Mockery::mock(ResponseInterface::class);
        $responseInterface->shouldReceive('getStatusCode')->once()->andReturn(200);
        $responseInterface->shouldReceive('toArray')->once()->andReturn(['success' => true]);

        $this->httpClient->shouldReceive('request')->once()->andReturn($responseInterface);

        $responseArray = $this->httpCommunication->$method('create');
        $this->assertArrayHasKey('success', $responseArray);
        $this->assertTrue($responseArray['success']);
    }

    /**
     * @return string[]
     */
    public function getMethods(): array
    {
        return [
            ['get'],
            ['post']
        ];
    }
}

