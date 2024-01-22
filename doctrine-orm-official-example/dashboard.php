<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

// list_bugs.php by DQL

use App\App;
use App\Entities\{Bug};
use App\Enums\BugStatus;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;

$userId = (int) $argv[1];

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
            ->where(
                $queryBuilder
                    ->expr()
                    ->andX(
                        $queryBuilder
                            ->expr()
                            ->eq('b.status', BugStatus::Open->value),
                        $queryBuilder
                            ->expr()
                            ->orX(
                                $queryBuilder->expr()->eq('e.id', ':id'),
                                $queryBuilder->expr()->eq('r.id', ':id')
                            ),
                    )
            )
            ->setParameter('id', $userId)
            ->orderBy('b.createdAt', 'DESC')
            ->getQuery();
        echo $query->getDQL();
        // echo PHP_EOL;
        // echo $query->getSQL();
        exit(0);
    }

    $dql
           = 'SELECT b, e, r FROM App\Entities\Bug b INNER JOIN b.engineer e INNER JOIN b.reporter r WHERE b.status = 0 AND (e.id = :id OR r.id = :id) ORDER BY b.createdAt DESC';
    $query = $entityManager->createQuery($dql);

    $bugs = $query
        ->setParameter('id', $userId)
        ->setMaxResults(30)
        ->getResult();

    echo 'You have created or assigned to '
        .count($bugs)
        .' open bugs: '
        .PHP_EOL;

    foreach ($bugs as $bug) {
        echo '    '
            .$bug->getId()
            .' - '
            .$bug->getDescription()
            .PHP_EOL;
    }
} catch (ORMException|Exception $e) {
    var_dump($e);
}
