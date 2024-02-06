<?php

declare(strict_types=1);

use App\Config;
use App\Enum\AppEnvironment;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use Slim\Views\Twig;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookup;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupCollectionInterface;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;
use Symfony\WebpackEncoreBundle\Asset\TagRenderer;
use Symfony\WebpackEncoreBundle\Twig\EntryFilesTwigExtension;
use Twig\Extra\Intl\IntlExtension;

use function DI\create;

class CustomEntrypointLookup implements EntrypointLookupCollectionInterface
{

    function getEntrypointLookup(string $buildName = null
    ): EntrypointLookupInterface {
        return new EntrypointLookup(BUILD_PATH.'/entrypoints.json');
    }

}

return [
    Config::class        => create(Config::class)->constructor(require CONFIG_PATH
        .'/app.php'),
    EntityManager::class => function (Config $conf) {
        $config     = ORMSetup::createAttributeMetadataConfiguration(
            paths: $conf->get('doctrine.entity_dir'),
            isDevMode: $conf->get('doctrine.dev_mode')
        );
        $connection = DriverManager::getConnection(
            $conf->get('doctrine.connection'),
            $config
        );

        return new EntityManager($connection, $config);
    },
    Twig::class          => function (
        Config $config,
        ContainerInterface $container
    ) {
        $twig = Twig::create(VIEW_PATH, [
            'cache'       => STORAGE_PATH.'/cache/templates',
            'auto_reload' => AppEnvironment::isDevelopment($config->get('app_environment')),
        ]);

        $twig->addExtension(new IntlExtension());
        $twig->addExtension(new EntryFilesTwigExtension($container));
        $twig->addExtension(new AssetExtension($container->get('webpack_encore.packages')));

        return $twig;
    },
    /**
     * The following bindings are needed for EntryFilesTwigExtension & AssetExtension to work for Twig
     */

    'webpack_encore.packages'     => function () {
        $manifestPath = BUILD_PATH.'/manifest.json';
        $strategy     = new JsonManifestVersionStrategy($manifestPath);
        $in           = new Package($strategy);

        return new Packages($in);
    },
    'webpack_encore.tag_renderer' => function (ContainerInterface $c) {
        $packages   = $c->get('webpack_encore.packages');
        $collection = new CustomEntrypointLookup();

        return new TagRenderer($collection, $packages);
    },
];
