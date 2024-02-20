<?php

namespace App\Middleware;

use App\Contracts\AuthInterface;
use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class AuthenticationMiddleware implements MiddlewareInterface
{

    public function __construct(private AuthInterface $auth) {}

    #[Override]
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $request = $request->withAttribute('user', $this->auth->getUser());

        return $handler->handle($request);
    }

}
