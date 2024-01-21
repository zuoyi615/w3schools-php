<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

// show_product.php <id>

use App\App;
use App\Entities\Product;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;

$id = $argv[1];

try {
    App::bootstrap();

    $entityManager = App::getEntityManager();
    $product       = $entityManager->find(Product::class, $id);

    if ($product === null) {
        echo "No Product found".PHP_EOL;
        exit(1);
    }

    echo sprintf("-%s".PHP_EOL, $product->getName());
} catch (ORMException|Exception $e) {
    var_dump($e);
}
