<?php

namespace App;

use App\Interfaces\TMDBMovieInterface;
use App\Services\TMDBMovieService;
use Dotenv\Dotenv;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\FilesystemLoader;

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

        /** Config Twig */
        $loader = new FilesystemLoader(VIEW_PATH);
        $twig   = new Environment($loader, [
            'cache'       => STORAGE_PATH.'/cache',
            'auto_reload' => true,
        ]);
        $twig->addExtension(new IntlExtension());

        $this->container->singleton(Environment::class, fn() => $twig);
        $this->container->bind(
            MailerInterface::class,
            fn() => new CustomMailer($this->config->mailer['dsn'])
        );
        $this->container->bind(
            TMDBMovieInterface::class,
            fn() => new TMDBMovieService($this->config->tmdb['token']),
        );

        return $this;
    }

    public function run(): void
    {
        try {
            $uri    = $this->request['uri'];
            $method = strtolower($this->request['method']);
            echo $this->router?->resolve($uri, $method);
        } catch (Exception|NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            http_response_code(404);
            var_dump($e);
        }
    }

}
