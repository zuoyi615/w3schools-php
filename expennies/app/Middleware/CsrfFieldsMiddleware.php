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
        $fields       = <<<CSRF_Fields
<input type="hidden" name="$csrfNameKey" value="$csrfName">
<input type="hidden" name="$csrfValueKey" value="$csrfValue">
CSRF_Fields;

        $data = [
            'keys'    => [
                'name'  => $csrfNameKey,
                'value' => $csrfValueKey,
            ],
            'name'    => $csrfName,
            'value'   => $csrfValue,
            'fields' => $fields,

        ];

        $this->twig->getEnvironment()->addGlobal('csrf', $data);

        return $handler->handle($request);
    }

}
