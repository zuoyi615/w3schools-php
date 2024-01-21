<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

use App\App;
use App\Entities\User;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;

// create_user.php <name>

$name = $argv[1];
$user = new User();
$user->setName($name);

try {
    App::bootstrap();
    $entityManager = App::getEntityManager();
    $entityManager->persist($user);
    $entityManager->flush();
    echo "Created Product with ID ".$user->getId().PHP_EOL;
} catch (ORMException|Exception $e) {
    var_dump($e);
}

