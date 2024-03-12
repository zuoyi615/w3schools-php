<?php

declare(strict_types=1);

use App\Auth;
use App\Config;
use App\Contracts\AuthInterface;
use App\Contracts\EntityManagerServiceInterface;
use App\Contracts\RequestValidatorFactoryInterface;
use App\Contracts\SessionInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Csrf;
use App\DataObjects\SessionConfig;
use App\Enum\AppEnvironment;
use App\Enum\SameSite;
use App\Enum\StorageDriver;
use App\RequestValidators\RequestValidatorFactory;
use App\RouterEntityBindStrategy;
use App\Services\EntityManagerService;
use App\Services\UserProviderService;
use App\Session;
use Clockwork\Clockwork;
use Clockwork\DataSource\DoctrineDataSource;
use Clockwork\Storage\FileStorage;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\App;
use Slim\Csrf\Guard;
use Slim\Factory\AppFactory;
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
    App::class                              => function (ContainerInterface $c) {
        AppFactory::setContainer($c);

        $app            = AppFactory::create();
        $router         = require CONFIG_PATH.'/routes/web.php';
        $addMiddlewares = require CONFIG_PATH.'/middleware.php';

        $app->getRouteCollector()->setDefaultInvocationStrategy(new RouterEntityBindStrategy());

        $router($app);

        $addMiddlewares($app);

        return $app;
    },
    Config::class                           => create(Config::class)->constructor(require CONFIG_PATH.'/app.php'),
    EntityManagerInterface::class           => function (Config $conf) {
        $config     = ORMSetup::createAttributeMetadataConfiguration(
            paths    : $conf->get('doctrine.entity_dir'),
            isDevMode: $conf->get('doctrine.dev_mode')
        );
        $connection = DriverManager::getConnection(
            $conf->get('doctrine.connection'),
            $config
        );

        return new EntityManager($connection, $config);
    },
    Twig::class                             => function (Config $config, ContainerInterface $c) {
        $twig = Twig::create(VIEW_PATH, [
            'cache'       => STORAGE_PATH.'/cache/templates',
            'auto_reload' => AppEnvironment::isDevelopment($config->get('app_environment')),
            // 'autoescape'  => true,
        ]);

        $twig->addExtension(new IntlExtension());
        $twig->addExtension(new EntryFilesTwigExtension($c));
        $twig->addExtension(new AssetExtension($c->get('webpack_encore.packages')));

        return $twig;
    },
    'webpack_encore.packages'               => function () {
        $manifestPath = BUILD_PATH.'/manifest.json';
        $strategy     = new JsonManifestVersionStrategy($manifestPath);
        $in           = new Package($strategy);

        return new Packages($in);
    },
    'webpack_encore.tag_renderer'           => function (ContainerInterface $c) {
        $packages   = $c->get('webpack_encore.packages');
        $collection = new CustomEntrypointLookup();

        return new TagRenderer($collection, $packages);
    },
    ResponseFactoryInterface::class         => function (App $app) {
        return $app->getResponseFactory();
    },
    AuthInterface::class                    => function (ContainerInterface $c) {
        return $c->get(Auth::class);
    },
    UserProviderServiceInterface::class     => function (ContainerInterface $c) {
        return $c->get(UserProviderService::class);
    },
    SessionInterface::class                 => function (Config $config) {
        $options = new SessionConfig(
            name     : $config->get('session.name', ''),
            flashName: $config->get('session.flash_name', 'flash'),
            secure   : $config->get('session.secure', true),
            httpOnly : $config->get('session.httponly', true),
            sameSite : SameSite::from($config->get('session.samesite', 'lax'))
        );

        return new Session($options);
    },
    RequestValidatorFactoryInterface::class => function (ContainerInterface $c) {
        return $c->get(RequestValidatorFactory::class);
    },
    'csrf'                                  => function (ResponseFactoryInterface $factory, Csrf $csrf) {
        return new Guard(
            responseFactory    : $factory,
            failureHandler     : $csrf->failureHandler(),
            persistentTokenMode: true,
        );
    },
    Filesystem::class                       => function (Config $config) {
        $adapter = match ($config->get('storage.driver')) {
            StorageDriver::Local => new LocalFilesystemAdapter(STORAGE_PATH),
            default => throw new RuntimeException('No matched storage driver found'),
        };

        return new Filesystem($adapter);
    },
    Clockwork::class                        => function (EntityManagerInterface $em) {
        $clockwork = new Clockwork();
        $clockwork->storage(new FileStorage(STORAGE_PATH.'/clockwork'));
        $clockwork->addDataSource(new DoctrineDataSource($em));

        return $clockwork;
    },
    EntityManagerServiceInterface::class    => function (EntityManagerInterface $em) {
        return new EntityManagerService($em);
    },
];
