<?php

namespace App;

use Dotenv\Dotenv;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Symfony\Component\Mailer\MailerInterface;

class App
{

    private Config $config;

    /**
     * @param  Container    $container
     * @param  Router|null  $router
     * @param  array        $request
     */
    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = [],
    ) {}

    public function initDB(array $config): void
    {
        $capsule = new Capsule();

        $capsule->addConnection($config);
        $capsule->setEventDispatcher(new Dispatcher($this->container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->config = new Config($_ENV);

        $this->initDB($this->config->db ?? []);

        $this->container->bind(
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
        } catch (Exception $e) {
            http_response_code(404);
            var_dump($e);
        }
    }

}
