<?php

  declare(strict_types=1);

  use Dotenv\Dotenv;
  use DIContainer\{App, Router};
  use DIContainer\Config;
  use DIContainer\Controllers\{HomeController};

  require_once 'vendor/autoload.php';

  const UPLOAD_PATH = __DIR__.DIRECTORY_SEPARATOR.'uploads';
  const VIEW_PATH   = __DIR__.DIRECTORY_SEPARATOR.'views';

  $dotenv  = Dotenv::createImmutable(__DIR__);
  $router  = new Router();
  $request = ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']];

  $dotenv->load();
  $router->get('/', [HomeController::class, 'index']);

  $app = new App($router, $request, new Config($_ENV));

  $app->run();
