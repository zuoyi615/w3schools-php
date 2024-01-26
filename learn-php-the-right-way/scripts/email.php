<?php

declare(strict_types=1);

use App\App;
use App\Services\EmailService;
use Illuminate\Container\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

require_once 'vendor/autoload.php';

$container = new Container();
$app       = new App($container);

$app->boot();

try {
    $container->get(EmailService::class)->sendQueuedEmails();
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    var_dump($e);
}
