<?php

namespace App\Middleware;

use App\Config;
use App\Services\RequestService;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;
use Symfony\Component\RateLimiter\RateLimiterFactory;

readonly class RateLimitMiddleware implements MiddlewareInterface
{

    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private RequestService           $requestService,
        private Config                   $config,
        private RateLimiterFactory       $rateLimiterFactory,
    ) {}

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $clientIp     = $this->requestService->getClientIp($request, $this->config->get('trusted_proxies'));
        $routeContext = RouteContext::fromRequest($request);
        $route        = $routeContext->getRoute();
        $limiter      = $this->rateLimiterFactory->create($route->getName().$clientIp);

        if ($limiter->consume()->isAccepted() === false) {
            return $this->responseFactory->createResponse(429, 'Too many requests.');
        }

        return $handler->handle($request);
    }

}
