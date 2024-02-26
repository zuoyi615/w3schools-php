<?php

namespace App;

use Closure;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

readonly class Csrf
{
    public function __construct(private ResponseFactoryInterface $responseFactory)
    {
    }

    public function failureHandler(): Closure
    {
        return function (Request $request, Handler $handler) {
            $response = $this->responseFactory->createResponse();
            $body = $response->getBody();
            $body->write(json_encode([
                'status' => 403,
                'message' => 'Failed CSRF check!'
            ]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(403);
        };
    }
}
