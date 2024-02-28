<?php

namespace App\Services;

use App\DataObjects\DataTableQueryParams;
use App\DataObjects\TransactionData;
use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\Pagination\Paginator;

readonly class TransactionService
{
    public function __construct(private EntityManager $em) {}

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    function create(TransactionData $data, User $user): Transaction
    {
        $transaction = new Transaction();
        $transaction->setUser($user);

        return $this->update($transaction, $data);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(Transaction $transaction, TransactionData $data): Transaction
    {
        $transaction->setDescription($data->description);
        $transaction->setAmount($data->amount);
        $transaction->setDate($data->date);
        $transaction->setCategory($data->category);

        $this->em->persist($transaction);
        $this->em->flush();

        return $transaction;
    }

    public function getPaginatedTransactions(DataTableQueryParams $params): Paginator
    {
        $query = $this
            ->em
            ->getRepository(Transaction::class)
            ->createQueryBuilder('t')
            ->leftJoin('t.category', 'c')
            ->setFirstResult($params->start)
            ->setMaxResults($params->length);

        $orderBy = $params->orderBy;
        $orderBy = in_array($orderBy, ['description', 'amount', 'date', 'category']) ? $orderBy : 'date';
        $orderDir = $params->orderDir;
        $orderDir = strtolower($orderDir) === 'asc' ? 'asc' : 'desc';
        if ($orderBy === 'category') {
            $query->orderBy('c.name', $orderDir);
        } else {
            $query->orderBy('t.'.$orderBy, $orderDir);
        }

        $search = $params->search;
        if (!empty($search)) {
            $search = addcslashes($search, '%_');
            $query->where('t.description LIKE :desc')->setParameter('desc', '%'.$search.'%');
        }

        return new Paginator($query);
    }

    public function getById(int $id): ?Transaction
    {
        return $this->em->getRepository(Transaction::class)->find($id);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(int $id): void
    {
        $transaction = $this->em->getRepository(Transaction::class)->find($id);
        if ($transaction) {
            $this->em->remove($transaction);
            $this->em->flush();
        }
    }

}
