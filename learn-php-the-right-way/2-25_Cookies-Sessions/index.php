<?php

  declare(strict_types=1);

  use CookieSession\Classes\{Home, Invoice};
  use CookieSession\Exceptions\RouteNotFoundException;
  use CookieSession\Router;

  require_once 'vendor/autoload.php';

  session_start();
  $router = new Router();
  $router
    ->get('/', [Home::class, 'index'])
    ->get('/invoices/create', [Invoice::class, 'create'])
    ->get('/invoices', [Invoice::class, 'index'])
    ->post('/invoices', [Invoice::class, 'store']);

  try {
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $uri    = $_SERVER['REQUEST_URI'];
    echo $router->resolve($uri, $method);
  } catch (RouteNotFoundException $e) {
    echo $e->getMessage();
  } finally {
  }

  // php -S localhost:8080 // run the command in terminal, starting a localhost server

  // phpinfo(); // output_buffering 4096
  // echo 1;
  // sleep(3);
  // echo 2;
  // sleep(3);
  // echo 3;
  // after 6s echo 123 on screen;
  // wait script executed or buffered content reaches 4096 bytes
  // echo ini_get('output_buffering');

  echo '<br />';
  print_r($_SESSION);

  echo '<br />';
  print_r($_COOKIE);
