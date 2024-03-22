<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\SimpleCache\CacheInterface;

readonly class RateLimitMiddleware implements MiddlewareInterface
{

    const int MAX_TIMES = 5;

    public function __construct(private CacheInterface $cache, private ResponseFactoryInterface $responseFactory) {}

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $clientIp = $request->getServerParams()['REMOTE_ADDRESS'];
        $cacheKey = 'rate_limit_'.$clientIp;
        $times    = (int) $this->cache->get($cacheKey, 0);

        if ($times > self::MAX_TIMES) {
            return $this->responseFactory->createResponse(429, 'Too many requests.');
        }

        $this->cache->set($cacheKey, $times + 1, 60);

        return $handler->handle($request);
    }

}
