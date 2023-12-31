<?php

  declare(strict_types=1);

  use _SERVER\Classes\{Home, Invoice};
  use _SERVER\Exceptions\RouteNotFoundException;
  use _SERVER\Router;

  require_once 'vendor/autoload.php';

  $router = new Router();
  $router
    ->register('/', [Home::class, 'index'])
    ->register('/invoices/create', [Invoice::class, 'create'])
    ->register('/invoices', [Invoice::class, 'index']);

  try {
    echo $router->resolve($_SERVER['REQUEST_URI']);
  } catch (RouteNotFoundException $e) {
    echo $e->getMessage();
  }

  // php -S localhost:8080 // run the command in terminal, starting a localhost server
