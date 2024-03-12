<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\EntityManagerServiceInterface;
use BadMethodCallException;
use Doctrine\ORM\EntityManagerInterface;

class EntityManagerService implements EntityManagerServiceInterface
{

    public function __construct(protected EntityManagerInterface $em) {}

    public function __call(string $name, array $args): mixed
    {
        if ($this->em && method_exists($this->em, $name)) {
            return call_user_func_array([$this->em, $name], $args);
        }

        throw new BadMethodCallException('Call to undefined method "'.$name.'"');
    }

    public function sync(object $entity = null): void
    {
        if ($entity) {
            $this->em->persist($entity);
        }

        $this->em->flush();
    }

    public function delete(object $entity, $sync = false): void
    {
        $this->em->remove($entity);

        if ($sync) {
            $this->sync();
        }
    }

    public function clear(string $entityName = null): void
    {
        if ($entityName === null) {
            $this->em->clear();

            return;
        }

        $unitWork = $this->em->getUnitOfWork();
        $entities = $unitWork->getIdentityMap()[$entityName] ?? [];

        foreach ($entities as $entity) {
            $this->em->detach($entity);
        }
    }

}
