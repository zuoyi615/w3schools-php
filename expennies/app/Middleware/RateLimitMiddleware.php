<?php

namespace App\Middleware;

use App\Config;
use App\Services\RequestService;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\SimpleCache\CacheInterface;

readonly class RateLimitMiddleware implements MiddlewareInterface
{

    private const int MAX_TIMES = 5;

    public function __construct(
        private CacheInterface           $cache,
        private ResponseFactoryInterface $responseFactory,
        private RequestService           $requestService,
        private Config                   $config,
    ) {}

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $cacheKey = 'rate_limit_'.$this->requestService->getClientIp($request, $this->config->get('trusted_proxies'));
        $times    = (int) $this->cache->get($cacheKey, 0);

        if ($times > self::MAX_TIMES) {
            return $this->responseFactory->createResponse(429, 'Too many requests.');
        }

        $this->cache->set($cacheKey, $times + 1, 60);

        return $handler->handle($request);
    }

}
