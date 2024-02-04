#!/usr/bin/env php
<?php

declare(strict_types=1);

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Application;

/** @var \Slim\App $app */
$app               = require_once __DIR__.'/bootstrap.php';
$container         = $app->getContainer();
$config            = new PhpFile(CONFIG_PATH.'/migrations.php');
$migrationCommands = require_once CONFIG_PATH.'/migration_commands.php';
$customCommands    = require_once CONFIG_PATH.'/commands.php';

try {
    $commands = array_map(
        fn($class) => $container->get($class),
        $customCommands
    );

    $entityManager     = $container->get(EntityManager::class);
    $dependencyFactory = DependencyFactory::fromEntityManager(
        $config,
        new ExistingEntityManager($entityManager)
    );

    $application = new Application('App Name', '0.0.1');
    $application->addCommands($migrationCommands($dependencyFactory));
    $application->addCommands($commands);
    ConsoleRunner::addCommands(
        $application,
        new SingleManagerProvider($entityManager)
    );

    $application->run();
} catch (Exception|NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    var_dump($e);
}
