<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class VerifyEmailMiddleware implements MiddlewareInterface
{

    public function __construct(private ResponseFactoryInterface $responseFactory) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var \App\Entity\User $user */
        $user = $request->getAttribute('user');
        if ($user->getVerifiedAt()) {
            return $handler->handle($request);
        }

        return $this->responseFactory->createResponse(302)->withHeader('Location', '/verify');
    }

}
