<?php

  declare(strict_types=1);

  use Dotenv\Dotenv;
  use PHPUnitMocking\{App, Router};
  use PHPUnitMocking\Config;
  use PHPUnitMocking\Controllers\{HomeController, InvoiceController};

  require_once 'vendor/autoload.php';

  const UPLOAD_PATH = __DIR__.DIRECTORY_SEPARATOR.'uploads';
  const VIEW_PATH   = __DIR__.DIRECTORY_SEPARATOR.'views';

  $dotenv  = Dotenv::createImmutable(__DIR__);
  $router  = new Router();
  $request = ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']];

  $dotenv->load();
  $router
    ->get('/', [HomeController::class, 'index'])
    ->get('/download', [HomeController::class, 'download'])
    ->post('/upload', [HomeController::class, 'upload'])
    ->get('/invoices/create', [InvoiceController::class, 'create'])
    ->get('/invoices', [InvoiceController::class, 'index'])
    ->post('/invoices', [InvoiceController::class, 'store']);

  $app = new App($router, $request, new Config($_ENV));

  $app->run();
