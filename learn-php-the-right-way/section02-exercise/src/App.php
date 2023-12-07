<?php

  declare(strict_types=1);

  namespace Exercise02;

  use Exception;

  class App {
    private static DB $db;

    public function __construct(private readonly Router $router, private readonly array $request, Config $config) {
      static::$db = new DB($config->db);
    }

    public function run(): void {
      try {
        $uri    = $this->request['uri'];
        $method = strtolower($this->request['method']);
        echo $this->router->resolve($uri, $method);
      } catch (Exception) {
        http_response_code(404);
        echo View::make('error/404');
      }
    }

    public static function db(): DB {
      return static::$db;
    }
  }
