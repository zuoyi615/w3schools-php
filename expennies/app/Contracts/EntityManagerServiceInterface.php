<?php

namespace App\Contracts;

use Doctrine\ORM\EntityManagerInterface;

/**
 * @mixin EntityManagerInterface
 */
interface EntityManagerServiceInterface
{

    public function __call(string $name, array $args): mixed;

    public function sync(object $entity = null): void;

    public function delete(object $entity, $sync = false): void;

    public function clear(string $entityName = null): void;

}
