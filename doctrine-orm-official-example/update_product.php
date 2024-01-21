<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

// update_product.php <id> <name>

use App\App;
use App\Entities\Product;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;

$id   = $argv[1];
$name = $argv[2];

try {
    App::bootstrap();

    $entityManager = App::getEntityManager();
    $product       = $entityManager->find(Product::class, $id);

    if ($product === null) {
        echo "No Product found".PHP_EOL;
        exit(1);
    }

    $product->setName($name);
    $entityManager->flush();
} catch (ORMException|Exception $e) {
    var_dump($e);
}
