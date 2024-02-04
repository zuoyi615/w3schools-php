#!/usr/bin/env php
<?php

declare(strict_types=1);
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/** @var \Slim\App $app */
$app       = require_once __DIR__.'/bootstrap.php';
$container = $app->getContainer();

try {
    $entityManager = $container->get(EntityManager::class);
    $commands      = [];

    ConsoleRunner::run(
        new SingleManagerProvider($entityManager),
        $commands
    );
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    var_dump($e);
}
