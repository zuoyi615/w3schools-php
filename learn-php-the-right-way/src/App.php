<?php

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Interfaces\PaymentGatewayInterface;
use App\Services\PaymentGatewayService;
use Dotenv\Dotenv;
use ReflectionException;
use Symfony\Component\Mailer\MailerInterface;

class App
{

    private static DB $db;

    private Config    $config;

    /**
     * @param  \App\Container  $container
     * @param  \App\Router|null  $router
     * @param  array  $request
     */
    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = [],
    ) {}

    public static function db(): DB
    {
        return static::$db;
    }

    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->config = new Config($_ENV);

        static::$db = new DB($this->config->db ?? []);

        $this->container->set(
            PaymentGatewayInterface::class,
            PaymentGatewayService::class
        );
        $this->container->set(
            MailerInterface::class,
            fn() => new CustomMailer($this->config->mailer['dsn'])
        );

        return $this;
    }

    public function run(): void
    {
        try {
            $uri    = $this->request['uri'];
            $method = strtolower($this->request['method']);
            echo $this->router?->resolve($uri, $method);
        } catch (RouteNotFoundException|Exceptions\Container\ContainerException|Exceptions\Container\NotFoundException|ReflectionException) {
            http_response_code(404);
            echo View::make('error/404');
        }
    }

}
