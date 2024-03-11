<?php

declare(strict_types=1);

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class EntityManagerService
{

    public function __construct(protected EntityManagerInterface $em) {}

    public function flush(): void
    {
        $this->em->flush();
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
