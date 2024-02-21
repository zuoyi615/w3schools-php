<?php

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

}
