<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Controllers\TransactionController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app
        ->get('/', [HomeController::class, 'index'])
        ->add(AuthMiddleware::class);

    $app
        ->group('', function (RouteCollectorProxy $guest) {
            $guest->get('/login', [AuthController::class, 'loginView']);
            $guest->post('/login', [AuthController::class, 'login']);
            $guest->get('/register', [AuthController::class, 'registerView']);
            $guest->post('/register', [AuthController::class, 'register']);
        })
        ->add(GuestMiddleware::class);

    $app
        ->post('/logout', [AuthController::class, 'logout'])
        ->add(AuthMiddleware::class);

    $app
        ->group('/categories', function (RouteCollectorProxy $categories) {
            $categories->get('', [CategoryController::class, 'index']);
            $categories->post('', [CategoryController::class, 'store']);
            $categories->get('/load', [CategoryController::class, 'load']);

            $id = '/{id:[0-9]+}';
            $categories->delete($id, [CategoryController::class, 'delete']);
            $categories->get($id, [CategoryController::class, 'get']);
            $categories->post($id, [CategoryController::class, 'update']);
        })
        ->add(AuthMiddleware::class);

    $app
        ->group('/transactions', function (RouteCollectorProxy $transactions) {
            $transactions->get('', [TransactionController::class, 'index']);
            $transactions->post('', [TransactionController::class, 'store']);
            $transactions->get('/load', [TransactionController::class, 'load']);

            $id = '/{id:[0-9]+}';
            $transactions->delete($id, [TransactionController::class, 'delete']);
            $transactions->get($id, [TransactionController::class, 'get']);
            $transactions->post($id, [TransactionController::class, 'update']);
        })
        ->add(AuthMiddleware::class);
};
