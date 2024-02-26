<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;

readonly class CategoryService
{

    public function __construct(private EntityManager $em)
    {
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function create(string $name, User $user): Category
    {
        $category = new Category();

        $category->setUser($user);

        $this->update($category, $name);

        return $category;
    }

    public function getPaginatedCategories(int $start, int $length): Paginator
    {
        $query = $this
            ->em
            ->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->setFirstResult($start)
            ->setMaxResults($length);

        return new Paginator($query);
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

    public function getById(int $id): ?Category
    {
        return $this
            ->em
            ->getRepository(Category::class)
            ->find($id);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(Category $category, string $name): Category
    {
        $category->setName($name);

        $this->em->persist($category);
        $this->em->flush();

        return $category;
    }

}
