#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use App\App;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

try {
    App::bootstrap();

    $entityManager = App::getEntityManager();
    $provider      = new SingleManagerProvider($entityManager);

    ConsoleRunner::run($provider);
} catch (Exception|MissingMappingDriverImplementation $e) {
    var_dump($e);
}
