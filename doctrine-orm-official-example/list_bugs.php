<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

// list_bugs.php by DQL

use App\App;
use App\Entities\{Bug};
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;

try {
    App::bootstrap();
    $entityManager = App::getEntityManager();

    $ok = false;
    if ($ok) { // generate DQL
        $queryBuilder = $entityManager->createQueryBuilder();
        $query        = $queryBuilder
            ->select('b, e, r')
            ->from(Bug::class, 'b')
            ->join('b.engineer', 'e')
            ->join('b.reporter', 'r')
            ->orderBy('b.createdAt', 'DESC')
            ->getQuery();
        echo $query->getDQL();
        echo PHP_EOL;
        echo $query->getSQL();
    }

    $dql
           = 'SELECT b, e, r FROM App\Entities\Bug b INNER JOIN b.engineer e INNER JOIN b.reporter r ORDER BY b.createdAt DESC';
    $query = $entityManager->createQuery($dql);

    $query->setMaxResults(30);
    $bugs = $query->getResult();

    foreach ($bugs as $bug) {
        /** @var Bug $bug */
        echo $bug->getDescription()
            .'-'
            .$bug->getCreatedAt()->format('Y.m.d')
            .PHP_EOL;
        echo '    Reported by: '.$bug->getReporter()->getName().PHP_EOL;
        echo '    Assigned by: '.$bug->getEngineer()->getName().PHP_EOL;
        foreach ($bug->getProducts() as $product) {
            echo "    Platform: ".$product->getName().PHP_EOL;
        }
        echo PHP_EOL;
    }
} catch (ORMException|Exception $e) {
    var_dump($e);
}
