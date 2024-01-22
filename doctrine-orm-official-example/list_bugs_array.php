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

    $dql   = 'SELECT b, e, r, p '
        .'FROM App\Entities\Bug b '
        .'INNER JOIN b.engineer e '
        .'INNER JOIN b.reporter r '
        .'INNER JOIN b.products p '
        .'ORDER BY b.createdAt DESC';
    $query = $entityManager->createQuery($dql);
    $bugs  = $query->getArrayResult();

    foreach ($bugs as $bug) {
        /** @var Bug $bug */
        echo $bug['description']
            .'-'
            .$bug['createdAt']->format('Y.m.d')
            .PHP_EOL;
        echo '    Reported by: '.$bug['reporter']['name'].PHP_EOL;
        echo '    Assigned by: '.$bug['engineer']['name'].PHP_EOL;
        foreach ($bug['products'] as $product) {
            echo "    Platform: ".$product['name'].PHP_EOL;
        }
        echo PHP_EOL;
    }
} catch (ORMException|Exception $e) {
    var_dump($e);
}
