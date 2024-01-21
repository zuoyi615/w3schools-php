<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

use App\App;
use App\Entities\{Bug, Product, User};
use App\Enums\BugStatus;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;

// create_bug.php <reporter-id> <engineer-id> <product-id>

$reportedId = $argv[1];
$engineerId = $argv[2];
$productIds = explode(',', $argv[3]);

try {
    App::bootstrap();
    $entityManager = App::getEntityManager();

    $reporter = $entityManager->find(User::class, $reportedId);
    $engineer = $entityManager->find(User::class, $engineerId);

    if (!$reporter || !$engineer) {
        echo 'No reporter and/or engineer found for the given ids'.PHP_EOL;
        exit(1);
    }

    $bug = new Bug();
    $bug
        ->setDescription('Something does not work')
        ->setCreatedAt(new DateTime('now'))
        ->setStatus(BugStatus::Open);

    foreach ($productIds as $productId) {
        $product = $entityManager->find(Product::class, $productId);
        if ($product !== null) {
            $bug->assignToProduct($product);
        }
    }

    $bug->setEngineer($engineer);
    $bug->setReporter($reporter);

    $entityManager->persist($bug);
    $entityManager->flush();

    echo 'new Bug id: '.$bug->getId().PHP_EOL;
} catch (ORMException|Exception $e) {
    var_dump($e);
}

