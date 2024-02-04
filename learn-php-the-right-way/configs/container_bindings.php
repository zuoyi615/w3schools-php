<?php

declare(strict_types=1);

use App\Config;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\{EntityManager, ORMSetup};
use Slim\Views\Twig;
use Twig\Extra\Intl\IntlExtension;

use function DI\create;

return [
    Config::class        => create(Config::class)->constructor($_ENV),
    EntityManager::class => function (Config $conf) {
        $config     = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__.'/../src/Entities'],
            isDevMode: true
        );
        $connection = DriverManager::getConnection($conf->db, $config);

        return new EntityManager($connection, $config);
    },
    Twig::class          => function (Config $config) {
        $twig = Twig::create(VIEW_PATH, [
            'cache'       => STORAGE_PATH.'/cache',
            'auto_reload' => $config->environment === 'development',
        ]);

        $twig->addExtension(new IntlExtension());

        return $twig;
    },
];
