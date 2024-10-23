<?php

namespace App\Middleware;

use App\Contracts\SessionInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class GuestMiddleware implements MiddlewareInterface
{

    public function __construct(
        private ResponseFactoryInterface $factory,
        private SessionInterface $session,
    ) {}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if ($this->session->get('user')) {
            return $this
                ->factory
                ->createResponse(302)
                ->withHeader('Location', '/');
        }

        return $handler->handle($request);
    }

}
