<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

use App\App;
use App\Entities\Product;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;

// create_product.php <name>

$name    = $argv[1];
$product = new Product();
$product->setName($name);

try {
    App::bootstrap();
    $entityManager = App::getEntityManager();
    $entityManager->persist($product);
    $entityManager->flush();
    echo "Created Product with ID ".$product->getId().PHP_EOL;
} catch (ORMException|Exception $e) {
    var_dump($e);
}
