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
        $errors = $_SESSION['errors'];
        if (!empty($errors)) {
            $this
                ->twig
                ->getEnvironment()
                ->addGlobal('errors', $errors);
        }

        return $handler->handle($request);
    }

}
