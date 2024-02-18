<?php

namespace App\Middleware;

use App\Exception\ValidationException;
use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class ValidationExceptionMiddleware implements MiddlewareInterface
{

    public function __construct(private ResponseFactoryInterface $factory) {}

    #[Override]
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

            $_SESSION['errors'] = $e->errors;

            $oldFormData        = $request->getParsedBody();
            $sensitiveFields    = ['password', 'confirmPassword'];
            $_SESSION['old']    = array_diff_key(
                $oldFormData,
                array_flip($sensitiveFields)
            );

            return $response
                ->withHeader('Location', $referer)
                ->withStatus(302);
        }
    }

}
