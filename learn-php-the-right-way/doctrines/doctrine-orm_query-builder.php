<?php

use App\Entities\Invoice;
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

    // building and writing something called DQL: doctrine query language, in terms of entities and mapped properties
    $query = $queryBuilder
        // ->select('i.createdAt', 'i.amount')
        ->select('i')
        ->from(Invoice::class, 'i')
        ->where('i.amount>:amount')
        ->setParameter('amount', 30)
        ->orderBy('i.createdAt', 'desc')
        ->getQuery(); // convert query builder into a query object

    // $dql = $query->getDQL();
    // $sql = $query->getSQL();
    // var_dump($dql);
    // var_dump($sql);

    // $dql
    //       = 'SELECT i.createdAt, i.amount FROM App\Entities\Invoice i WHERE i.amount>:amount ORDER BY i.createdAt desc';
    // $query = $entityManager->createQuery($dql);
    // $query->getResult();

    // $invoices = $query->getArrayResult();
    // var_dump($invoices);

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






