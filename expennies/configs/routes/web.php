<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Controllers\PasswordResetController;
use App\Controllers\ProfileController;
use App\Controllers\ReceiptController;
use App\Controllers\TransactionController;
use App\Controllers\VerifyController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\ValidateSignatureMiddleware;
use App\Middleware\VerifyEmailMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('', function (RouteCollectorProxy $route) {
        $route->get('/', [HomeController::class, 'index']);

        $route->group('/categories', function (RouteCollectorProxy $categories) {
            $categories->get('', [CategoryController::class, 'index']);
            $categories->post('', [CategoryController::class, 'store']);
            $categories->get('/load', [CategoryController::class, 'load']);

            $id = '/{category:[0-9]+}';
            $categories->delete($id, [CategoryController::class, 'delete']);
            $categories->get($id, [CategoryController::class, 'get']);
            $categories->post($id, [CategoryController::class, 'update']);
        });

        $route->group('/transactions', function (RouteCollectorProxy $transactions) {
            $transactions->get('', [TransactionController::class, 'index']);
            $transactions->post('', [TransactionController::class, 'store']);
            $transactions->get('/load', [TransactionController::class, 'load']);
            $transactions->post('/import', [TransactionController::class, 'import']);

            $transactionId = '/{transaction:[0-9]+}';
            $transactions->delete($transactionId, [TransactionController::class, 'delete']);
            $transactions->get($transactionId, [TransactionController::class, 'get']);
            $transactions->post($transactionId, [TransactionController::class, 'update']);
            $transactions->post($transactionId.'/review', [TransactionController::class, 'toggleReviewed']);

            $receiptId = '/{receipt:[0-9]+}';
            $transactions->post($transactionId.'/receipts', [ReceiptController::class, 'store']);
            $transactions->get($transactionId.'/receipts'.$receiptId, [ReceiptController::class, 'download']);
            $transactions->delete($transactionId.'/receipts'.$receiptId, [ReceiptController::class, 'delete']);
        });

        $route->group('/profile', function (RouteCollectorProxy $profile) {
            $profile->get('', [ProfileController::class, 'index']);
            $profile->post('', [ProfileController::class, 'update']);
        });
    })->add(VerifyEmailMiddleware::class)->add(AuthMiddleware::class);

    $app
        ->group('', function (RouteCollectorProxy $guest) {
            $guest->get('/login', [AuthController::class, 'loginView']);
            $guest->post('/login', [AuthController::class, 'login']);
            $guest->post('/login/two-factor', [AuthController::class, 'twoFactorLogin']);
            $guest->get('/register', [AuthController::class, 'registerView']);
            $guest->post('/register', [AuthController::class, 'register']);
            $guest->get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm']);
            $guest->post('/forgot-password', [PasswordResetController::class, 'handleForgotPasswordRequest']);
            $guest->post('/reset-password/{token}', [PasswordResetController::class, 'resetPassword']);
            $guest
                ->get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])
                ->setName('password-reset')
                ->add(ValidateSignatureMiddleware::class);
        })
        ->add(GuestMiddleware::class);

    $app
        ->group('', function (RouteCollectorProxy $route) {
            $route->post('/logout', [AuthController::class, 'logout']);
            $route->get('/verify', [VerifyController::class, 'index']);
            $route->post('/verify', [VerifyController::class, 'resend']);
            $route
                ->get('/verify/{id:[0-9]+}/{hash}', [VerifyController::class, 'verify'])
                ->setName('verify')
                ->add(ValidateSignatureMiddleware::class);
        })
        ->add(AuthMiddleware::class);
};
