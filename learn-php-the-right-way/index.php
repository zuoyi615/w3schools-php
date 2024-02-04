<?php

declare(strict_types=1);

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

/** @var \Slim\App $app */
$app       = require_once __DIR__.'/bootstrap.php';
$container = $app->getContainer();
$router    = require_once CONFIG_PATH.'/routes.php';
$router($app);

try {
    $app->add(TwigMiddleware::create($app, $container->get(Twig::class)));
    $app->run();
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    var_dump($e);
}

