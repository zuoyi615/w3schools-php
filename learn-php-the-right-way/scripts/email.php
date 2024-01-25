<?php

declare(strict_types=1);

use App\App;
use App\Services\EmailService;
use Illuminate\Container\Container;

require_once 'vendor/autoload.php';

$container = new Container();
$app       = new App($container);

$app->boot();

try {
    $container->get(EmailService::class)->sendQueuedEmails();
} catch (Exception $e) {
    var_dump($e);
}
