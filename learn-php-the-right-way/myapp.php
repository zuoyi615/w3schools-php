#!/usr/bin/env php
<?php

declare(strict_types=1);

use App\Commands\MyCommand;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\CurrentCommand;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\Migrations\Tools\Console\Command\DumpSchemaCommand;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\Migrations\Tools\Console\Command\ListCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\Migrations\Tools\Console\Command\RollupCommand;
use Doctrine\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\Migrations\Tools\Console\Command\SyncMetadataCommand;
use Doctrine\Migrations\Tools\Console\Command\UpToDateCommand;
use Doctrine\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Application;

/** @var \Slim\App $app */
$app       = require_once __DIR__.'/bootstrap.php';
$container = $app->getContainer();
$config    = new PhpFile(CONFIG_PATH.'/migrations.php');

try {
    $entityManager     = $container->get(EntityManager::class);
    $dependencyFactory = DependencyFactory::fromEntityManager(
        $config,
        new ExistingEntityManager($entityManager)
    );

    $commands = [
        new CurrentCommand($dependencyFactory),
        new DiffCommand($dependencyFactory),
        new DumpSchemaCommand($dependencyFactory),
        new ExecuteCommand($dependencyFactory),
        new GenerateCommand($dependencyFactory),
        new LatestCommand($dependencyFactory),
        new MigrateCommand($dependencyFactory),
        new RollupCommand($dependencyFactory),
        new StatusCommand($dependencyFactory),
        new VersionCommand($dependencyFactory),
        new UpToDateCommand($dependencyFactory),
        new SyncMetadataCommand($dependencyFactory),
        new ListCommand($dependencyFactory),
        new MyCommand(),
    ];

    $application = new Application('App Name', '0.0.1');
    $application->addCommands($commands);
    ConsoleRunner::addCommands(
        $application,
        new SingleManagerProvider($entityManager)
    );

    $application->run();
} catch (Exception|NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    var_dump($e);
}
