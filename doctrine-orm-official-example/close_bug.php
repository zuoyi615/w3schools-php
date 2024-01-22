<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

// close_bug.php <id>

use App\App;
use App\Entities\Bug;
use App\Enums\BugStatus;
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

    if ($bug->getStatus() === BugStatus::Open) {
        $bug->close();
    }

    $entityManager->flush();

    echo 'Bug: '.$bug->getStatus()->toString().PHP_EOL;
} catch (ORMException|Exception $e) {
    var_dump($e);
}
