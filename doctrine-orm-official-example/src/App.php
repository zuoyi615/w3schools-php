<?php

namespace App;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;

class App
{

    private static EntityManager $entityManager;

    /**
     * @throws MissingMappingDriverImplementation
     * @throws Exception
     */
    public static function bootstrap(): void
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [dirname(__DIR__).'/src/Entities'],
            isDevMode: true
        );

        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'path'   => __DIR__.'/../db.sqlite',
        ], $config);

        static::$entityManager = new EntityManager($connection, $config);
    }

    public static function getEntityManager(): EntityManager
    {
        return static::$entityManager;
    }

}
