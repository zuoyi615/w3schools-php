<?php

namespace App\Middleware;

use App\Exception\SessionException;
use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartSessionsMiddleware implements MiddlewareInterface
{

    #[Override]
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException('Session has already been started.');
        }

        if (headers_sent($filename, $line)) {
            throw new SessionException('Headers already sent.');
        }

        session_set_cookie_params([
            'secure'   => true,
            'httponly' => true,
            'samesite' => 'lax',
        ]);
        session_start();

        $response = $handler->handle($request);

        session_write_close(); // avoid concurrent writings

        return $response;
    }

}
