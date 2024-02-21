<?php

namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class CsrfFieldsMiddleware implements MiddlewareInterface
{

    public function __construct(
        private Twig $twig,
        private ContainerInterface $c,
    ) {}

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $csrf         = $this->c->get('csrf');
        $csrfNameKey  = $csrf->getTokenNameKey();
        $csrfValueKey = $csrf->getTokenValueKey();
        $csrfName     = $csrf->getTokenName();
        $csrfValue    = $csrf->getTokenValue();

        $data = [
            'keys'  => [
                'name'  => $csrfNameKey,
                'value' => $csrfValueKey,
            ],
            'name'  => $csrfName,
            'value' => $csrfValue,
        ];

        $this->twig->getEnvironment()->getGlobal('csrf', $data);

        return $handler->handle($request);
    }

}
