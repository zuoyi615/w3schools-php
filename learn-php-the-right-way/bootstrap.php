<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

require_once 'vendor/autoload.php';
require_once 'configs/path_constants.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = require_once CONFIG_PATH.'/container.php';

AppFactory::setContainer($container);

return AppFactory::create();
