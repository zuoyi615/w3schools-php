<?php

  namespace AttributedRouter;

  use AttributedRouter\Exceptions\RouteNotFoundException;
  use AttributedRouter\Interfaces\PaymentGatewayInterface;
  use AttributedRouter\Services\PaymentGatewayService;

  class App {

    private static DB $db;

    public function __construct(
      protected Container $container,
      protected Router $router,
      protected array $request,
      protected Config $config
    ) {
      static::$db = new DB($config->db ?? []);
      $this->container->set(PaymentGatewayInterface::class, PaymentGatewayService::class);
    }

    public function run(): void {
      try {
        $uri    = $this->request['uri'];
        $method = strtolower($this->request['method']);
        echo $this->router->resolve($uri, $method);
      } catch (RouteNotFoundException) {
        http_response_code(404);
        echo View::make('error/404');
      }
    }

    public static function db(): DB {
      return static::$db;
    }
  }
