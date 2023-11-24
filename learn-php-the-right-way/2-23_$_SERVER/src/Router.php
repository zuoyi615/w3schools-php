<?php

  namespace _SERVER;

  use _SERVER\Exceptions\RouteNotFoundException;

  class Router {
    private array $routes = [];

    public function register(string $route, callable $action): self {
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

      throw  new RouteNotFoundException();
    }
  }

