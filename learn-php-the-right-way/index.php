<?php

declare(strict_types=1);

use App\{App, Container, Router};
use App\Controllers\{HomeController};
use App\Controllers\UserController;

require_once 'vendor/autoload.php';

const UPLOAD_PATH = __DIR__.DIRECTORY_SEPARATOR.'uploads';
const VIEW_PATH   = __DIR__.DIRECTORY_SEPARATOR.'views';

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
        ]
    );
} catch (ReflectionException $e) {
}

$app = new App($container, $router, $request);

// echo '<pre>';
// print_r($router->routes());
// echo '</pre>';

$app->boot()->run();
