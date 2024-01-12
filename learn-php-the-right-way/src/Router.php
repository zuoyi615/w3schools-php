<?php

declare(strict_types=1);

namespace App;

use App\Attributes\Route;
use App\Exceptions\Container\ContainerException;
use App\Exceptions\Container\NotFoundException;
use App\Exceptions\RouteNotFoundException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

class Router
{

    private array $routes = [];

    public function __construct(private readonly Container $container) {}

    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * @throws ReflectionException
     */
    public function registerRoutesFromControllerAttributes(array $controllers
    ): void {
        foreach ($controllers as $controller) {
            $reflectionController = new ReflectionClass($controller);
            foreach ($reflectionController->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class,
                    ReflectionAttribute::IS_INSTANCEOF);
                if (count($attributes) !== 0) {
                    foreach ($attributes as $attribute) {
                        /**@var Route $route */
                        $route = $attribute->newInstance();
                        $this->register($route->getPath(), $route->getMethod(),
                            [$controller, $method->getName()]);
                    }
                }
            }
        }
    }

    public function register(
        string $route,
        string $method,
        callable|array $action
    ): void {
        $this->routes[$route][$method] = $action;
    }

    public function post(string $route, callable|array $action): static
    {
        $this->register($route, 'post', $action);

        return $this;
    }

    /**
     * @param  string  $uri
     * @param $method
     *
     * @return mixed
     * @throws ContainerException
     * @throws NotFoundException
     * @throws ReflectionException
     * @throws RouteNotFoundException
     */
    public function resolve(string $uri, $method): mixed
    {
        $route = explode('?', $uri)[0];
        $action = $this->routes[$route][$method] ?? null;
        if (is_callable($action)) {
            return call_user_func($action);
        }

        if ( ! is_array($action)) {
            throw new RouteNotFoundException();
        }

        if (count($action) !== 2) {
            throw new RouteNotFoundException();
        }

        [$class, $method] = $action;
        if ( ! class_exists($class)) {
            throw new RouteNotFoundException();
        }

        $instance = $this->container->get($class);
        if ( ! method_exists($instance, $method)) {
            throw new RouteNotFoundException();
        }

        return call_user_func_array([$instance, $method], []);
    }

    public function get(string $route, callable|array $action): static
    {
        $this->register($route, 'get', $action);

        return $this;
    }

}

