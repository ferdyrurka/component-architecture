<?php
declare(strict_types=1);

namespace App\Infrastructure\Microservices\Communication\Sync;

use App\Infrastructure\Microservices\Communication\CommunicationInterface;
use App\Infrastructure\Microservices\Communication\Exception\UnsuccessfulRequestException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpCommunication implements CommunicationInterface
{
    private const USER_AGENT = 'Symfony Monolith';

    private const REQUEST_DEFAULT_OPTIONS = [
        'headers' => [
            'User-Agent' => self::USER_AGENT,
        ],
    ];

    private HttpClientInterface $httpClient;

    private string $domain;

    private int $apiVersion;

    public function __construct(HttpClientInterface $httpClient, string $domain, int $apiVersion)
    {
        $this->httpClient = $httpClient;
        $this->domain = $domain;
        $this->apiVersion = $apiVersion;
    }

    public function get(string $path): array
    {
        $response = $this->sendRequest('GET', $path);

        return $response->toArray();
    }

    public function post(string $path, array $body = []): array
    {
        $bodyJson = json_encode($body);
        $response = $this->sendRequest('POST', $path, ['body' => $bodyJson]);

        return $response->toArray();
    }

    private function sendRequest(string $method, string $path, array $options = []): ResponseInterface
    {
        $uri = $this->prepareUri($path);

        $response =  $this->httpClient->request(
            $method,
            $uri,
            array_merge(self::REQUEST_DEFAULT_OPTIONS, $options)
        );

        if (($code = $response->getStatusCode()) !== 200) {
            $content = $response->getContent(false);
            throw new UnsuccessfulRequestException(
                sprintf(
                    'Request for uri %s is unsuccessful. Return status code: %d and content: %s',
                    $response->getInfo()['url'],
                    $code,
                    $content
                ),
                $content
            );
        }

        return $response;
    }

    private function prepareUri(string $path): string
    {
        return sprintf('%s/api/v%d/%s', $this->domain, $this->apiVersion, $path);
    }
}
