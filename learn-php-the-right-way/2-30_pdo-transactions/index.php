<?php

  declare(strict_types=1);

  use PDOTransactions\Controllers\{HomeController, InvoiceController};
  use PDOTransactions\Exceptions\RouteNotFoundException;
  use PDOTransactions\{Router, View};
  use Dotenv\Dotenv;

  require_once 'vendor/autoload.php';
  const UPLOAD_PATH = __DIR__.DIRECTORY_SEPARATOR.'uploads';
  const VIEW_PATH   = __DIR__.DIRECTORY_SEPARATOR.'views';

  $dotenv = Dotenv::createImmutable(__DIR__); // where .env located
  $dotenv->load();

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
    http_response_code(404);
    echo View::make('error/404');
  }
