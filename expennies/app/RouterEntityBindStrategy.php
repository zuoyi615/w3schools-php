<?php

declare(strict_types=1);

namespace App;

use App\Contracts\EntityManagerServiceInterface;
use InvalidArgumentException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionException;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use Slim\Interfaces\InvocationStrategyInterface;

readonly class RouterEntityBindStrategy implements InvocationStrategyInterface
{

    public function __construct(private EntityManagerServiceInterface $em, private ResponseFactoryInterface $factory) {}

    public function __invoke(
        callable               $callable,
        ServerRequestInterface $request,
        ResponseInterface      $response,
        array                  $routeArguments
    ): ResponseInterface {
        $callableReflection = $this->createReflectionForCallable($callable);
        if ($callableReflection === null) {
            return $callable($request, $response, $routeArguments);
        }

        $resolvedArguments = [];
        foreach ($callableReflection->getParameters() as $parameter) {
            $type = $parameter->getType();
            if (!$type) {
                continue;
            }

            $paramName = $parameter->getName();
            $typeName  = $type->getName();

            if ($type->isBuiltin()) {
                if ($typeName === 'array' && $paramName === 'args') {
                    $resolvedArguments[] = $routeArguments;
                }
            } else {
                if ($typeName === ServerRequestInterface::class) {
                    $resolvedArguments[] = $request;
                } elseif ($typeName === ResponseInterface::class) {
                    $resolvedArguments[] = $response;
                } else {
                    $entityId = $routeArguments[$paramName] ?? null;
                    if (!$entityId || $parameter->allowsNull()) {
                        $message = 'Unable to resolve argument "'.$paramName.'" in the callable';
                        throw new InvalidArgumentException($message);
                    }

                    $entity = $this->em->getRepository($typeName)->find($entityId);
                    if (!$entity) {
                        return $this->factory->createResponse(404, 'Resource Not Found');
                    }

                    $resolvedArguments[] = $entity;
                }
            }
        }

        return $callable(...$resolvedArguments);
    }

    public function createReflectionForCallable(callable|array $callable): ?ReflectionFunctionAbstract
    {
        try {
            if (!is_array($callable)) {
                return new ReflectionFunction($callable);
            }

            return new ReflectionMethod($callable[0], $callable[1]);
        } catch (ReflectionException) {
            return null;
        }
    }

}
