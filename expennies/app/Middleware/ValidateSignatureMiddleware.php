<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Config;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

readonly class ValidateSignatureMiddleware implements MiddlewareInterface
{

    public function __construct(private Config $config) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri   = $request->getUri();
        $query = $request->getQueryParams();

        $originalSignature = $query['signature'] ?? '';
        $expiration        = (int) $query['expiration'] ?? 0;

        unset($query['signature']);

        $url = (string) $uri->withQuery(http_build_query($query));

        $newSignature = hash_hmac('sha256', $url, $this->config->get('app_key'));
        if ($expiration <= time() || !hash_equals($newSignature, $originalSignature)) {
            throw new RuntimeException('Failed to verify signature');
        }

        return $handler->handle($request);
    }

}
