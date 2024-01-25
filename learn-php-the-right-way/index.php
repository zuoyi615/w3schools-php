<?php

declare(strict_types=1);

use App\{App, Router};
use App\Controllers\{HomeController, InvoiceController, UserController};
use Illuminate\Container\Container;

require_once 'vendor/autoload.php';

const VIEW_PATH = __DIR__.DIRECTORY_SEPARATOR.'views';

$container = new Container();
$router    = new Router($container);
$request   = [
    'uri'    => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD'],
];

try {
    $router->registerRoutesFromControllerAttributes(
        [
            HomeController::class,
            UserController::class,
            InvoiceController::class,
        ]
    );
} catch (ReflectionException $e) {
}

$app = new App($container, $router, $request);

$app->boot()->run();
