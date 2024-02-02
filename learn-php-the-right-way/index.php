<?php

declare(strict_types=1);

use App\Controllers\{HomeController, InvoiceController};
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Error\LoaderError;
use Twig\Extra\Intl\IntlExtension;

require_once 'vendor/autoload.php';

const STORAGE_PATH = __DIR__.'/storage';
const VIEW_PATH    = __DIR__.DIRECTORY_SEPARATOR.'views';

$app = AppFactory::create();

$app->get('/', [HomeController::class, 'index']);
$app->get('/invoices', [InvoiceController::class, 'index']);

try {
    $twig = Twig::create(VIEW_PATH, [
        'cache'       => STORAGE_PATH.'/cache',
        'auto_reload' => true,
    ]);
    $twig->addExtension(new IntlExtension());
    $app->add(TwigMiddleware::create($app, $twig));
} catch (LoaderError $e) {
    var_dump($e);
}

$app->run();
