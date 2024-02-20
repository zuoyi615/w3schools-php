<?php

namespace App\Middleware;

use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class OldFormDataMiddleware implements MiddlewareInterface
{

    public function __construct(private Twig $twig) {}

    #[Override]
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if (!empty($_SESSION['old'])) {
            $errors = $_SESSION['old'];
            $this
                ->twig
                ->getEnvironment()
                ->addGlobal('old', $errors);
            unset($_SESSION['old']);
        }

        return $handler->handle($request);
    }

}
