<?php

namespace App\Middleware;

use App\Contracts\SessionInterface;
use App\Exception\ValidationException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class ValidationExceptionMiddleware implements MiddlewareInterface
{

    public function __construct(
        private ResponseFactoryInterface $factory,
        private SessionInterface $session,
    ) {}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (ValidationException $e) {
            $response = $this->factory->createResponse();
            $params   = $request->getServerParams();
            $referer  = $params['HTTP_REFERER'];

            $oldData         = $request->getParsedBody();
            $sensitiveFields = ['password', 'confirmPassword'];
            $this->session->flash('errors', $e->errors);
            $this->session->flash(
                'old',
                array_diff_key(
                    $oldData,
                    array_flip($sensitiveFields)
                )
            );

            return $response
                ->withHeader('Location', $referer)
                ->withStatus(302);
        }
    }

}
