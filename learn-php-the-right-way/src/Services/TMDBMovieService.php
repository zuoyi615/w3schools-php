<?php

namespace App\Services;

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

    public function __construct(private readonly string $token) {}

    /**
     * @throws GuzzleException
     */
    public function authenticate(): array
    {
        $stack = HandlerStack::create();
        $stack->push($this->getRetryMiddleware(3));

        $client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 5,
            'handler'  => $stack,
        ]);

        $response = $client->get('authentication', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token,
                'accept'        => 'application/json',
            ],
            'proxy'   => [
                'http'  => 'http://127.0.0.1:7890',
                'https' => 'http://127.0.0.1:7890',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
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

}
