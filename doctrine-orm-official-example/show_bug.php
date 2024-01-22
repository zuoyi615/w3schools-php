<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

// show_bug.php <id>

use App\App;
use App\Entities\Bug;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;

$id = (int) $argv[1];

try {
    App::bootstrap();

    $entityManager = App::getEntityManager();
    $bug           = $entityManager->find(Bug::class, $id);

    if ($bug === null) {
        echo "No Product found".PHP_EOL;
        exit(1);
    }

    echo 'Bug: '.$bug->getDescription().PHP_EOL;
    echo 'Engineer: '.$bug->getEngineer()->getName().PHP_EOL;
} catch (ORMException|Exception $e) {
    var_dump($e);
}
