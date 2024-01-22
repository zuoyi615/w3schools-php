<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;

class BugRepository extends EntityRepository
{

    public function getRecentBugs($number = 30)
    {
        $dql   = 'SELECT b, e, r '
            .'FROM App\Entities\Bug b '
            .'INNER JOIN b.engineer e '
            .'INNER JOIN b.reporter r '
            .'ORDER BY b.createdAt DESC';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($number);

        return $query->getResult();
    }

    public function getRecentBugsArray($number = 30): array
    {
        $dql = 'SELECT b, e, r, p '
            .'FROM App\Entities\Bug b '
            .'INNER JOIN b.engineer e '
            .'INNER JOIN b.reporter r '
            .'INNER JOIN b.products p '
            .'ORDER BY b.createdAt DESC';

        return $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setMaxResults($number)
            ->getArrayResult();
    }

    public function getUserBugs(int $userId, $number = 15)
    {
        $dql = 'SELECT b, e, r '
            .'FROM App\Entities\Bug b '
            .'INNER JOIN b.engineer e '
            .'INNER JOIN b.reporter r '
            .'WHERE b.status = 0 AND (e.id = :id OR r.id = :id) '
            .'ORDER BY b.createdAt DESC';

        return $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameter('id', $userId)
            ->setMaxResults($number)
            ->getResult();
    }

    public function getOpenBugsByProduct(): array
    {
        $dql = 'SELECT p.id, p.name, count(b.id) AS openBugs '
            .'FROM App\Entities\Bug b '
            .'INNER JOIN b.products p '
            .'WHERE b.status=0 '
            .'GROUP BY p.id';

        return $this
            ->getEntityManager()
            ->createQuery($dql)
            ->getScalarResult();
    }

}
