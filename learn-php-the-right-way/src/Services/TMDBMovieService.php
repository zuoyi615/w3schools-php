<?php

namespace App\Services;

use App\DTO\AuthenticationResult;
use App\DTO\SearchResult;
use App\Interfaces\TMDBMovieInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class TMDBMovieService implements TMDBMovieInterface
{

    private string $baseUrl = 'https://api.themoviedb.org/3/';

    private Client $client;

    public function __construct(private readonly string $token)
    {
        $stack = HandlerStack::create();
        $stack->push($this->getRetryMiddleware(3));

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 5,
            'handler'  => $stack,
            'headers'  => [
                'Authorization' => 'Bearer '.$this->token,
                'accept'        => 'application/json',
            ],
            'proxy'    => [
                'http'  => 'http://127.0.0.1:7890',
                'https' => 'http://127.0.0.1:7890',
            ],
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function authenticate(): AuthenticationResult
    {
        $response = $this->client->get('authentication');

        $result = json_decode($response->getBody()->getContents(), true);

        return new AuthenticationResult(
            success: $result['success'],
            statusCode: $result['status_code'],
            statusMessage: $result['status_message'],
        );
    }

    public function getRetryMiddleware(int $maxRetry = 5): callable
    {
        return Middleware::retry(function (
            int $retries,
            RequestInterface $request,
            ?ResponseInterface $response = null,
            ?RuntimeException $e = null
        ) use ($maxRetry) {
            if ($retries >= $maxRetry) {
                return false;
            }

            $retryStatuses = [249, 304, 302, 401, 503, 404];
            if (in_array($response?->getStatusCode(), $retryStatuses)) {
                return true;
            }

            if ($e instanceof ConnectException) {
                return true;
            }

            return false;
        });
    }

    /**
     * @throws GuzzleException
     */
    public function getPopularMovies(): array
    {
        $params   = [
            'language' => 'en-US',
            'page'     => 1,
        ];
        $response = $this->client->get('person/popular', [
            'query' => $params,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws GuzzleException
     */
    public function searchMovies(string $query): SearchResult
    {
        $params   = [
            'query'         => $query,
            'include_adult' => false,
            'language'      => 'en-US',
            'page'          => 1,
        ];
        $response = $this->client->get('search/collection', [
            'query' => $params,
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return new SearchResult(
            page: $result['page'],
            results: $result['results']
        );
    }

}
