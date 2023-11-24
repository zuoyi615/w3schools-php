<?php

  declare(strict_types=1);

  use _SERVER\Exceptions\RouteNotFoundException;
  use _SERVER\Router;

  require_once 'vendor/autoload.php';

  // echo "<pre>";
  // print_r($_SERVER);
  // echo "</pre>";

  $router = new Router();
  $router
    ->register(
      '/',
      function () {
        echo 'Home';
      }
    )
    ->register(
      '/invoices',
      function () {
        echo 'Invoices';
      }
    );

  try {
    echo $router->resolve($_SERVER['REQUEST_URI']);
  } catch (RouteNotFoundException $e) {
    echo $e->getMessage();
  }

  // php -S localhost:8080 // run the command in terminal, starting a localhost server
