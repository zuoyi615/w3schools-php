<?php

  declare(strict_types=1);

  require_once 'vendor/autoload.php';

  use Dotenv\Dotenv;
  use Exercise02\{App, Config, Router};
  use Exercise02\Controllers\Home;

  $dotenv = Dotenv::createImmutable(__DIR__);
  $dotenv->load();

  const UPLOAD_PATH = __DIR__.DIRECTORY_SEPARATOR.'uploads';
  const VIEW_PATH   = __DIR__.DIRECTORY_SEPARATOR.'views';

  $router = new Router();
  $router
    ->get('/', [Home::class, 'index'])
    ->get('/upload', [Home::class, 'upload'])
    ->get('/transactions', [Home::class, 'transactions']);

  $request = ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']];
  $app     = new App($router, $request, new Config($_ENV));
  $app->run();
