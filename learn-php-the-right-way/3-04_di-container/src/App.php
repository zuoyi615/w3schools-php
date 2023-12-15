<?php

  namespace DIContainer;

  use DIContainer\Exceptions\RouteNotFoundException;
  use DIContainer\Services\EmailService;
  use DIContainer\Services\InvoiceService;
  use DIContainer\Services\PaymentGatewayService;
  use DIContainer\Services\SalesTaxService;

  class App {

    private static DB        $db;
    private static Container $container;

    public function __construct(protected Router $router, protected array $request, protected Config $config) {
      static::$db        = new DB($config->db ?? []);
      static::$container = new Container();

      // also instantiate dependencies explicit
      static::$container->set(SalesTaxService::class, fn() => new SalesTaxService());
      static::$container->set(PaymentGatewayService::class, fn() => new PaymentGatewayService());
      static::$container->set(EmailService::class, fn() => new EmailService());
      static::$container->set(InvoiceService::class, function (Container $c) {
        return new InvoiceService(
          $c->get(SalesTaxService::class),
          $c->get(PaymentGatewayService::class),
          $c->get(EmailService::class),
        );
      });
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

    public static function container(): Container {
      return static::$container;
    }
  }
