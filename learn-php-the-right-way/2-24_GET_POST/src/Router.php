<?php

  namespace GetPost;

  use GetPost\Exceptions\RouteNotFoundException;

  class Router {
    private array $routes = [];

    public function register(string $route, callable|array $action): self {
      $this->routes[$route] = $action;
      return $this;
    }

    /**
     * @throws RouteNotFoundException
     */
    public function resolve(string $uri): mixed {
      $route  = explode('?', $uri)[0];
      $action = $this->routes[$route] ?? null;
      if (is_callable($action)) {
        return call_user_func($action);
      }

      if (!is_array($action)) {
        throw  new RouteNotFoundException();
      }

      if (count($action) !== 2) {
        throw  new RouteNotFoundException();
      }

      [$class, $method] = $action;
      if (!class_exists($class)) {
        throw  new RouteNotFoundException();
      }

      $instance = new $class();
      if (!method_exists($instance, $method)) {
        throw  new RouteNotFoundException();
      }

      return call_user_func_array([$instance, $method], []);
    }
  }

