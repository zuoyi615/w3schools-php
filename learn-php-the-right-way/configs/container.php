<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$bindings         = __DIR__.'/container_bindings.php';
$containerBuilder->addDefinitions($bindings);

try {
    return $containerBuilder->build();
} catch (Exception $e) {
    var_dump($e);

    return null;
}
