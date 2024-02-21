<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManager;

readonly class CategoryService
{

    public function __construct(private EntityManager $em) {}

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function create(string $name, User $user): Category
    {
        $category = new Category();

        $category->setName($name);
        $category->setUser($user);

        $this->em->persist($category);
        $this->em->flush();

        return $category;
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Category::class)->findAll();
    }

    /**
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function delete(int $id): void
    {
        $category = $this
            ->em
            ->getRepository(Category::class)
            ->find($id);
        $this->em->remove($category);
        $this->em->flush();
    }

}
