<?php

  declare(strict_types=1);

  use GetPost\Classes\{Home, Invoice};
  use GetPost\Exceptions\RouteNotFoundException;
  use GetPost\Router;

  require_once 'vendor/autoload.php';

  $router = new Router();
  $router
    ->get('/', [Home::class, 'index'])
    ->get('/invoices/create', [Invoice::class, 'create'])
    ->get('/invoices', [Invoice::class, 'index'])
    ->post('/invoices', [Invoice::class, 'store']);

  try {
    echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
  } catch (RouteNotFoundException $e) {
    echo $e->getMessage();
  }

  // php -S localhost:8080 // run the command in terminal, starting a localhost server
