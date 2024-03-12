<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\InvocationStrategyInterface;

class RouterEntityBindStrategy implements InvocationStrategyInterface
{

    public function __invoke(
        callable               $callable,
        ServerRequestInterface $request,
        ResponseInterface      $response,
        array                  $routeArguments
    ): ResponseInterface {
        return $callable($request, $response, $routeArguments);
    }

}
