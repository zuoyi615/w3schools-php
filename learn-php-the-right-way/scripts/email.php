<?php

declare(strict_types=1);

use App\{App, Container};
use App\Exceptions\Container\{ContainerException, NotFoundException};
use App\Services\EmailService;

require_once 'vendor/autoload.php';

$container = new Container();
$app       = new App($container);

$app->boot();

try {
    $container->get(EmailService::class)->sendQueuedEmails();
} catch (ContainerException|NotFoundException|ReflectionException) {
}
