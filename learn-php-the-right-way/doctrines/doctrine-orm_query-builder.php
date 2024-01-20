<?php

use App\Entities\{Invoice, InvoiceItem};
use App\Enums\InvoiceStatus;
use Doctrine\DBAL\{DriverManager, Exception};
use Doctrine\ORM\{EntityManager, ORMSetup};
use Doctrine\ORM\Exception\{MissingMappingDriverImplementation};
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

    // Transaction
    // $entityManager->beginTransaction();
    // $entityManager->commit();
    // $entityManager->rollback();
    // $entityManager->wrapInTransaction();

    // native sql
    // $entityManager->createNativeQuery();

    $queryBuilder = $entityManager->createQueryBuilder();

    $query = $queryBuilder
        ->select('i', 'it')
        ->from(Invoice::class, 'i')
        ->join('i.items', 'it')
        ->where(
            $queryBuilder
                ->expr()
                ->andX(
                    $queryBuilder->expr()->gt('i.amount', ':amount'),
                    $queryBuilder
                        ->expr()
                        ->orX(
                            $queryBuilder->expr()->eq('i.status', ':status'),
                            $queryBuilder->expr()->gte('i.createdAt', ':date'),
                        )
                )
        )
        ->setParameter('amount', 30)
        ->setParameter('status', InvoiceStatus::Paid->value)
        ->setParameter('date', '2024-01-19 00:00:00')
        ->orderBy('i.createdAt', 'desc')
        ->getQuery();

    // var_dump($query->getArrayResult());
    $invoices = $query->getResult();

    foreach ($invoices as $invoice) {
        /** @var Invoice $invoice */
        echo $invoice
                ->getCreatedAt()->format('Y/m/d H:m:s').', '
            .$invoice->getAmount().', '
            .$invoice->getStatus()->toString()
            .PHP_EOL;

        foreach ($invoice->getItems() as $item) {
            /** @var InvoiceItem $item */
            echo ' - '.$item->getDescription()
                .', '.$item->getQuantity()
                .', '.$item->getUnitPrice()
                .PHP_EOL;
        }
    }
} catch (MissingMappingDriverImplementation|Exception $e) {
    var_dump($e);
}






