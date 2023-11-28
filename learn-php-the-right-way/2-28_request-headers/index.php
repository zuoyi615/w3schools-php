<?php

  declare(strict_types=1);

  use RequestHeaders\Controllers\{HomeController, InvoiceController};
  use RequestHeaders\Exceptions\RouteNotFoundException;
  use RequestHeaders\{Router, View};

  const UPLOAD_PATH = __DIR__.DIRECTORY_SEPARATOR.'uploads';
  const VIEW_PATH   = __DIR__.DIRECTORY_SEPARATOR.'views';
  require_once 'vendor/autoload.php';

  $router = new Router();
  $router
    ->get('/', [HomeController::class, 'index'])
    ->get('/download', [HomeController::class, 'download'])
    ->post('/upload', [HomeController::class, 'upload'])
    ->get('/invoices/create', [InvoiceController::class, 'create'])
    ->get('/invoices', [InvoiceController::class, 'index'])
    ->post('/invoices', [InvoiceController::class, 'store']);

  try {
    echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
  } catch (RouteNotFoundException $e) {
    // header('HTTP/1.1 404 Not Found');
    http_response_code(404);
    echo View::make('error/404');
  }
