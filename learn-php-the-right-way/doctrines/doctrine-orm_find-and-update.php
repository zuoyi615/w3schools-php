<?php

use App\Entities\{Invoice};
use App\Enums\InvoiceStatus;
use Doctrine\DBAL\{DriverManager, Exception};
use Doctrine\ORM\{EntityManager, ORMSetup};
use Doctrine\ORM\{OptimisticLockException, TransactionRequiredException};
use Doctrine\ORM\Exception\{MissingMappingDriverImplementation, ORMException};
use Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$connectionParams = [
    'dbname'   => $_ENV['DB_DATABASE'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'host'     => $_ENV['DB_HOST'],
    'driver'   => 'pdo_mysql',
];

try {
    $connection    = DriverManager::getConnection($connectionParams);
    $config        = ORMSetup::createAttributeMetadataConfiguration([
        __DIR__.'/../src/Entities',
    ]);
    $entityManager = new EntityManager($connection, $config);

    $invoice = $entityManager->find(Invoice::class, 4);

    var_dump($invoice->getInvoiceNumber());
    $invoice->setStatus(InvoiceStatus::Paid);
    $entityManager->flush();

    $description = $invoice->getItems()->get(0)->getDescription();
    var_dump($description);
    $invoice->getItems()->get(0)->setDescription('Hello World!');
    $entityManager->flush();
} catch (MissingMappingDriverImplementation|Exception|OptimisticLockException|TransactionRequiredException|ORMException $e) {
    var_dump($e);
}






