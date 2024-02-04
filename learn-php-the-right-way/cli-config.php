<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;

// Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders
$config = new PhpFile('migrations.php');
$dotenv = Dotenv::createImmutable(__DIR__);

$dotenv->load();

$connectionParams = [
    'dbname'   => $_ENV['DB_DATABASE'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'host'     => $_ENV['DB_HOST'],
    'driver'   => 'pdo_mysql',
];

$ORMConfig = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__.'/src/Entities'],
    isDevMode: true,
);

try {
    $connection    = DriverManager::getConnection($connectionParams);
    $entityManager = new EntityManager($connection, $ORMConfig);

    return DependencyFactory::fromEntityManager(
        $config,
        new ExistingEntityManager($entityManager)
    );
} catch (Exception|MissingMappingDriverImplementation $e) {
    var_dump($e);
}
