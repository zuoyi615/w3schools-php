<?php

  namespace UploadFile;

  use UploadFile\Exceptions\RouteNotFoundException;

  class Router {
    private array $routes = [];

    public function getRoutes(): array {
      return $this->routes;
    }

    private function register(string $method, string $route, callable|array $action): void {
      $this->routes[$method][$route] = $action;
    }

    public function get(string $route, callable|array $action): self {
      $this->register('get', $route, $action);
      return $this;
    }

    public function post(string $route, callable|array $action): self {
      $this->register('post', $route, $action);
      return $this;
    }

    /**
     * @throws RouteNotFoundException
     */
    public function resolve(string $uri, string $method): mixed {
      $route  = explode('?', $uri)[0];
      $action = $this->routes[$method][$route] ?? null;
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

