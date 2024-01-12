<?php

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Interfaces\PaymentGatewayInterface;
use App\Services\PaymentGatewayService;

class App
{
    private static DB $db;

    /*
     * @param $container
     * @param $router
     * @param $request
     * @param $config
     */
    public function __construct(
        protected Container $container,
        protected Router $router,
        protected array $request,
        protected Config $config
    ) {
        static::$db = new DB($config->db ?? []);
        $this->container->set(PaymentGatewayInterface::class, PaymentGatewayService::class);
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run(): void
    {
        try {
            $uri    = $this->request['uri'];
            $method = strtolower($this->request['method']);
            echo $this->router->resolve($uri, $method);
        } catch (RouteNotFoundException) {
            http_response_code(404);
            echo View::make('error/404');
        }
    }
}
