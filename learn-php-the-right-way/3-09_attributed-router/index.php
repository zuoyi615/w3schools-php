<?php

  declare(strict_types=1);

  use Dotenv\Dotenv;
  use AttributedRouter\{App, Container, Router};
  use AttributedRouter\Config;
  use AttributedRouter\Controllers\{HomeController};

  require_once 'vendor/autoload.php';

  const UPLOAD_PATH = __DIR__.DIRECTORY_SEPARATOR.'uploads';
  const VIEW_PATH   = __DIR__.DIRECTORY_SEPARATOR.'views';

  $dotenv    = Dotenv::createImmutable(__DIR__);
  $container = new Container();
  $router    = new Router($container);
  $request   = ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']];

  $dotenv->load();

  try {
    $router->registerRoutesFromControllerAttributes(
      [
        HomeController::class,
      ]
    );
  } catch (ReflectionException $e) {
  }

  $app = new App($container, $router, $request, new Config($_ENV));

  $app->run();
