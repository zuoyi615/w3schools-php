<?php

  declare(strict_types=1);

  use MVCPattern\Controllers\{HomeController, InvoiceController};
  use MVCPattern\Exceptions\RouteNotFoundException;
  use MVCPattern\Router;

  const UPLOAD_PATH = __DIR__.DIRECTORY_SEPARATOR.'uploads';
  const VIEW_PATH   = __DIR__.DIRECTORY_SEPARATOR.'views';
  require_once 'vendor/autoload.php';

  $router = new Router();
  $router
    ->get('/', [HomeController::class, 'index'])
    ->post('/upload', [HomeController::class, 'upload'])
    ->get('/invoices/create', [InvoiceController::class, 'create'])
    ->get('/invoices', [InvoiceController::class, 'index'])
    ->post('/invoices', [InvoiceController::class, 'store']);

  try {
    echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
  } catch (RouteNotFoundException $e) {
    echo $e->getMessage();
  }
