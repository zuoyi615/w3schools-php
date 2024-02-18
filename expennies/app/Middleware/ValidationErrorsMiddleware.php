<?php

namespace App\Middleware;

use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class ValidationErrorsMiddleware implements MiddlewareInterface
{

    public function __construct(private Twig $twig) {}

    #[Override]
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if (!empty($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];
            $this
                ->twig
                ->getEnvironment()
                ->addGlobal('errors', $errors);
            unset($_SESSION['errors']);
        }

        return $handler->handle($request);
    }

}
