<?php

namespace App\Middleware;

use App\Contracts\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class OldFormDataMiddleware implements MiddlewareInterface
{

    public function __construct(
        private Twig $twig,
        private SessionInterface $session,
    ) {}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if ($errors = $this->session->getFlash('old')) {
            $this
                ->twig
                ->getEnvironment()
                ->addGlobal('old', $errors);
        }

        return $handler->handle($request);
    }

}
