<?php

  declare(strict_types=1);

  use Dotenv\Dotenv;
  use DIContainer\{App, Container, Router};
  use DIContainer\Config;
  use DIContainer\Controllers\{HomeController};

  require_once 'vendor/autoload.php';

  const UPLOAD_PATH = __DIR__.DIRECTORY_SEPARATOR.'uploads';
  const VIEW_PATH   = __DIR__.DIRECTORY_SEPARATOR.'views';

  $dotenv    = Dotenv::createImmutable(__DIR__);
  $container = new Container();
  $router    = new Router($container);
  $request   = ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']];

  $dotenv->load();
  $router->get('/', [HomeController::class, 'index']);

  $app = new App($container, $router, $request, new Config($_ENV));

  $app->run();
