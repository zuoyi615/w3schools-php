<?php

  declare(strict_types=1);

  use UploadFile\Classes\{Home, Invoice};
  use UploadFile\Exceptions\RouteNotFoundException;
  use UploadFile\Router1;

  const UPLOAD_PATH = __DIR__.DIRECTORY_SEPARATOR.'uploads';
  require_once 'vendor/autoload.php';

  // const UPLOAD_PATH = __DIR__.DIRECTORY_SEPARATOR.'uploads';

  $router = new Router1();
  $router
    ->get('/', [Home::class, 'index'])
    ->post('/upload', [Home::class, 'upload'])
    ->get('/invoices/create', [Invoice::class, 'create'])
    ->get('/invoices', [Invoice::class, 'index'])
    ->post('/invoices', [Invoice::class, 'store']);

  try {
    echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
  } catch (RouteNotFoundException $e) {
    echo $e->getMessage();
  }

  // php -S localhost:8080 // run the command in terminal, starting a localhost server
  // echo UPLOAD_PATH;
