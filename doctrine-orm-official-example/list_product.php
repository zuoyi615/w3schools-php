<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

use App\App;
use App\Entities\Product;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;

try {
    App::bootstrap();
    $entityManager     = App::getEntityManager();
    $productRepository = $entityManager->getRepository(Product::class);
    $products          = $productRepository->findAll();
    foreach ($products as $product) {
        /** @var $product Product */
        echo sprintf("-%s".PHP_EOL, $product->getName());
    }
} catch (ORMException|Exception $e) {
    var_dump($e);
}
