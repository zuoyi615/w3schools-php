<?php

namespace App\Services;

use App\Contracts\EntityManagerServiceInterface;
use App\DataObjects\DataTableQueryParams;
use App\DataObjects\TransactionData;
use App\Entity\Transaction;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\Tools\Pagination\Paginator;

readonly class TransactionService
{
    
    public function __construct(private EntityManagerServiceInterface $em) {}
    
    function create(TransactionData $data, User $user): Transaction
    {
        $transaction = new Transaction();
        $transaction->setUser($user);
        
        return $this->update($transaction, $data);
    }
    
    public function update(Transaction $transaction, TransactionData $data): Transaction
    {
        $transaction->setDescription($data->description);
        $transaction->setAmount($data->amount);
        $transaction->setDate($data->date);
        $transaction->setCategory($data->category);
        
        return $transaction;
    }
    
    public function getPaginatedTransactions(DataTableQueryParams $params): Paginator
    {
        $query = $this
            ->em
            ->getRepository(Transaction::class)
            ->createQueryBuilder('t')
            ->select('t', 'c', 'r')
            ->leftJoin('t.category', 'c')
            ->leftJoin('t.receipts', 'r')
            ->setFirstResult($params->start)
            ->setMaxResults($params->length);
        
        $orderBy  = $params->orderBy;
        $orderBy  = in_array($orderBy, ['description', 'amount', 'date', 'category']) ? $orderBy : 'date';
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
    
    public function toggleReviewed(Transaction $transaction): void
    {
        $transaction->setWasReviewed(!$transaction->isWasReviewed());
    }
    
    public function getTotals(DateTime $startDate, DateTime $endDate): array
    {
        $query = $this->em->createQuery(
            'SELECT SUM(t.amount) AS net,
                    SUM(CASE WHEN t.amount > 0 THEN t.amount ELSE 0 END) AS income,
                    SUM(CASE WHEN t.amount < 0 THEN ABS(t.amount) ELSE 0 END) as expense
             FROM App\Entity\Transaction t
             WHERE t.date BETWEEN :start AND :end'
        );
        
        $query->setParameter('start', $startDate->format('Y-m-d 00:00:00'));
        $query->setParameter('end', $endDate->format('Y-m-d 23:59:59'));
        
        return $query->getSingleResult();
    }
    
    public function getRecentTransactions(int $limit): array
    {
        return $this->em
            ->getRepository(Transaction::class)
            ->createQueryBuilder('t')
            ->select('t', 'c')
            ->leftJoin('t.category', 'c')
            ->orderBy('t.date', 'desc')
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
    }
    
    public function getMonthlySummary(int $year): array
    {
        $query = $this->em->createQuery(
            'SELECT SUM(CASE WHEN t.amount > 0 THEN t.amount ELSE 0 END) as income,
                    SUM(CASE WHEN t.amount < 0 THEN abs(t.amount) ELSE 0 END) as expense,
                    MONTH(t.date) as m
             FROM App\Entity\Transaction t
             WHERE YEAR(t.date) = :year
             GROUP BY m
             ORDER BY m ASC'
        );
        
        $query->setParameter('year', $year);
        
        return $query->getArrayResult();
    }
    
}
