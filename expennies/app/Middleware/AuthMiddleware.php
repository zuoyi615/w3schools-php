<?php

namespace App\Middleware;

use App\Contracts\AuthInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class AuthMiddleware implements MiddlewareInterface
{

    public function __construct(
        private Twig $twig,
        private ResponseFactoryInterface $factory,
        private AuthInterface $auth
    ) {}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if ($user = $this->auth->getUser()) {
            $this->twig->getEnvironment()->addGlobal('auth', [
                'id'   => $user->getId(),
                'name' => $user->getName(),
            ]);
            $request = $request->withAttribute('user', $user);

            return $handler->handle($request);
        }

        return $this
            ->factory
            ->createResponse(302)
            ->withHeader('Location', '/login');
    }

}
