<?php

use App\Entities\{Invoice, InvoiceItem};
use App\Enums\InvoiceStatus;
use Doctrine\DBAL\{DriverManager, Exception};
use Doctrine\ORM\{EntityManager, Exception\ORMException, ORMSetup};
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
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

$items = [
    ['Item 01', 1, 15],
    ['Item 02', 2, 7.5],
    ['Item 03', 4, 3.75],
];

try {
    $connection    = DriverManager::getConnection($connectionParams);
    $config        = ORMSetup::createAttributeMetadataConfiguration([
        __DIR__.'/../src/Entities',
    ]);
    $entityManager = new EntityManager($connection, $config);
    $invoice       = new Invoice();

    $invoice
        ->setAmount(45)
        ->setInvoiceNumber('0000_0000_0001')
        ->setStatus(InvoiceStatus::Pending);

    foreach ($items as [$description, $quantity, $unitPrice]) {
        $item = new InvoiceItem();
        $item
            ->setDescription($description)
            ->setQuantity($quantity)
            ->setUnitPrice($unitPrice)
            ->setCreatedAt(new DateTime());

        $invoice->addItem($item);
    }

    $entityManager->persist($invoice);
    $entityManager->flush();
} catch (MissingMappingDriverImplementation|ORMException|Exception $e) {
    var_dump($e);
}






