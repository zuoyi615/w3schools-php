<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;

/** @var ContainerInterface $container */
$container = require __DIR__.'/../bootstrap.php';

$container->get(App::class)->run();
