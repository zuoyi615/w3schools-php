<?php

use App\Entities\Invoice;
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

    $queryBuilder = $entityManager->createQueryBuilder();

    // WHERE amount >: amount AND (status = :status OR created_at >= :date)
    // SELECT i FROM App\Entities\Invoice i WHERE i.amount > :amount AND (i.status = :status OR i.createdAt >= :date) ORDER BY i.createdAt desc
    $query = $queryBuilder
        ->select('i')
        ->from(Invoice::class, 'i')
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
        // ->andWhere('i.status = :status') // incorrect
        // ->orWhere('i.createdAt >= :date') // incorrect
        ->setParameter('amount', 30)
        ->setParameter('status', InvoiceStatus::Paid->value)
        ->setParameter('date', '2024-01-19 00:00:00')
        ->orderBy('i.createdAt', 'desc')
        ->getQuery(); // convert query builder into a query object

    // $sql = $query->getSQL();
    // var_dump($sql);
    $dql = $query->getDQL();
    var_dump($dql);

    $invoices = $query->getResult();

    foreach ($invoices as $invoice) {
        /** @var Invoice $invoice */
        echo $invoice->getCreatedAt()->format('Y/m/d H:m:s').', '
            .$invoice->getAmount().', '.$invoice->getStatus()->toString()
            .PHP_EOL;
    }
} catch (MissingMappingDriverImplementation|Exception $e) {
    var_dump($e);
}






