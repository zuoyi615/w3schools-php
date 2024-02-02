<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Error\LoaderError;
use Twig\Extra\Intl\IntlExtension;

require_once 'vendor/autoload.php';

const STORAGE_PATH = __DIR__.'/storage';
const VIEW_PATH    = __DIR__.DIRECTORY_SEPARATOR.'views';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    $view = Twig::fromRequest($request);

    return $view->render($response, 'index.twig');
});

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
