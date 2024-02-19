<?php

namespace App\Middleware;

use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class AuthMiddleware implements MiddlewareInterface
{

    public function __construct(private ResponseFactoryInterface $factory) {}

    #[Override]
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if (empty($_SESSION['user'])) {
            return $this
                ->factory
                ->createResponse(302)
                ->withHeader('Location', '/login');
        }

        return $handler->handle($request);
    }

}
