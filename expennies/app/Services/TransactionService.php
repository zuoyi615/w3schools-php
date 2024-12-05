<?php

namespace App\Services;

use App\Contracts\EntityManagerServiceInterface;
use App\DataObjects\DataTableQueryParams;
use App\DataObjects\TransactionData;
use App\Entity\Transaction;
use App\Entity\User;
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
    
    public function getTotals(\DateTime $startDate, \DateTime $endDate): array
    {
        return ['net' => 800, 'income' => 3000, 'expense' => 2200];
    }
    
    public function getRecentTransactions(int $limit): array
    {
        return [];
    }
    
    public function getMonthlySummary(int $year): array
    {
        return [
            ['income' => 1500, 'expense' => 1100, 'm' => '3'],
            ['income' => 2000, 'expense' => 1800, 'm' => '4'],
            ['income' => 2500, 'expense' => 1900, 'm' => '5'],
            ['income' => 2600, 'expense' => 1950, 'm' => '6'],
            ['income' => 3000, 'expense' => 2200, 'm' => '7'],
        ];
    }
    
}
