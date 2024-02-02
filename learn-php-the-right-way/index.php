<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once 'vendor/autoload.php';
require_once 'configs/path_constants.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = require_once CONFIG_PATH.'/container.php';
$router    = require_once CONFIG_PATH.'/routes.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$router($app);

$app->add(TwigMiddleware::create($app, $container->get(Twig::class)));

$app->run();
