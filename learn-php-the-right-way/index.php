<?php

declare(strict_types=1);

use App\Config;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\{EntityManager, ORMSetup};
use Dotenv\Dotenv;
use App\Controllers\{HomeController, InvoiceController};
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Error\LoaderError;
use Twig\Extra\Intl\IntlExtension;
use DI\Container;

use function DI\create;

require_once 'vendor/autoload.php';

const STORAGE_PATH = __DIR__.'/storage';
const VIEW_PATH    = __DIR__.DIRECTORY_SEPARATOR.'views';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = new Container();

$container->set(Config::class, create(Config::class)->constructor($_ENV));
$container->set(EntityManager::class, function (Config $conf) {
    $config     = ORMSetup::createAttributeMetadataConfiguration(
        paths: [__DIR__.'/src/Entities'],
        isDevMode: true
    );
    $connection = DriverManager::getConnection($conf->db, $config);

    return new EntityManager($connection, $config);
});

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->get('/', [HomeController::class, 'index']);
$app->get('/invoices', [InvoiceController::class, 'index']);

try {
    $twig = Twig::create(VIEW_PATH, [
        'cache'       => STORAGE_PATH.'/cache',
        'auto_reload' => true,
    ]);
    $twig->addExtension(new IntlExtension());
    $app->add(TwigMiddleware::create($app, $twig));
} catch (LoaderError $e) {
    var_dump($e);
}

$app->run();
