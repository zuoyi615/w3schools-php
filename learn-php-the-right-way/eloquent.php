<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

use Dotenv\Dotenv;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$capsule = new Capsule();
$config  = [
    'database'  => $_ENV['DB_DATABASE'],
    'username'  => $_ENV['DB_USER'],
    'password'  => $_ENV['DB_PASS'],
    'host'      => $_ENV['DB_HOST'],
    'driver'    => $_ENV['DB_DRIVER'] ?? 'mysql',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
];

$capsule->addConnection($config);
$capsule->setEventDispatcher(new Dispatcher(new Container()));
$capsule->setAsGlobal();
$capsule->bootEloquent();
