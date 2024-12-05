<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\EntityManagerServiceInterface;
use App\DataObjects\DataTableQueryParams;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

readonly class CategoryService
{
    
    public function __construct(private EntityManagerServiceInterface $em) {}
    
    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function create(string $name, User $user): Category
    {
        $category = new Category();
        
        $category->setUser($user);
        $this->update($category, $name);
        
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
    public function update(Category $category, string $name): Category
    {
        $category->setName($name);
        
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
    public function getAllKeyedByName(): array
    {
        $categories  = $this->em->getRepository(Category::class)->findAll();
        $categoryMap = [];
        
        foreach ($categories as $category) {
            $key               = strtolower($category->getName());
            $categoryMap[$key] = $category;
        }
        
        return $categoryMap;
    }
    
    public function getTopSpendingCategories(int $limit): array
    {
        return [
            ['name' => 'Category 1', 'total' => 700],
            ['name' => 'Category 2', 'total' => 550],
            ['name' => 'Category 3', 'total' => 475],
            ['name' => 'Category 4', 'total' => 325],
        ];
    }
    
}
