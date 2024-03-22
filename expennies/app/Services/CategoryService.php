<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\EntityManagerServiceInterface;
use App\DataObjects\DataTableQueryParams;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Psr\SimpleCache\CacheInterface;

readonly class CategoryService
{

    public function __construct(private EntityManagerServiceInterface $em, private CacheInterface $cache) {}

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function create(string $name, User $user): Category
    {
        $category = new Category();
        $userId   = $user->getId();

        $category->setUser($user);
        $this->update($category, $name, $userId);
        $this->cache->delete($this->getCacheKey($userId));

        return $category;
    }

    public function getPaginatedCategories(DataTableQueryParams $params): Paginator
    {
        $query = $this
            ->em
            ->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->setFirstResult($params->start)
            ->setMaxResults($params->length);

        $orderBy  = $params->orderBy;
        $orderBy  = in_array($orderBy, ['name', 'createdAt', 'updatedAt']) ? $orderBy : 'createdAt';
        $orderDir = strtolower($params->orderDir) === 'asc' ? 'asc' : 'desc';

        $search = $params->search;
        if (!empty($search)) {
            $search = addcslashes($search, '%_');
            $query->where('c.name LIKE :name')->setParameter('name', '%'.$search.'%');
        }

        $query->orderBy('c.'.$orderBy, $orderDir);

        return new Paginator($query);
    }

    public function getById(int $id): ?Category
    {
        return $this->em->getRepository(Category::class)->find($id);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function update(Category $category, string $name, int $userId): Category
    {
        $category->setName($name);
        $this->cache->delete($this->getCacheKey($userId));

        return $category;
    }

    public function getCategoryNames(): array
    {
        return $this
            ->em
            ->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->select('c.id', 'c.name')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getAllKeyedByName(int $userId): array
    {
        $key = $this->getCacheKey($userId);
        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $categories  = $this->em->getRepository(Category::class)->findAll();
        $categoryMap = [];

        foreach ($categories as $category) {
            $key               = strtolower($category->getName());
            $categoryMap[$key] = $category;
        }

        $this->cache->set($key, $categoryMap);

        return $categoryMap;
    }

    private function getCacheKey(int $userId): string
    {
        return 'categories_keyed_by_name_'.$userId;
    }

}
