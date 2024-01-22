<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\App;
use App\Entities\Bug;
use App\Enums\BugStatus;
use Doctrine\ORM\Exception\ORMException;

try {
    App::bootstrap();
    $entityManager = App::getEntityManager();

    $ok = false;
    if ($ok) { // generate DQL
        $status       = BugStatus::Open->value;
        $queryBuilder = $entityManager->createQueryBuilder();
        $query        = $queryBuilder
            ->select('p.id, p.name, count(b.id) AS openBugs')
            ->from(Bug::class, 'b')
            ->join('b.products', 'p')
            ->where("b.status={$status}")
            ->setParameter('status', BugStatus::Open->value)
            ->groupBy('p.id')
            ->getQuery();
        echo $query->getDQL();
        exit(0);
    }

    $dql
        = 'SELECT p.id, p.name, count(b.id) AS openBugs FROM App\Entities\Bug b INNER JOIN b.products p WHERE b.status=0 GROUP BY p.id';

    $productBugs = $entityManager->createQuery($dql)->getScalarResult();

    foreach ($productBugs as $productBug) {
        echo $productBug['name']
            ." has "
            .$productBug['openBugs']
            ." open bugs."
            .PHP_EOL;
    }
} catch (ORMException|Exception $e) {
    var_dump($e);
}
