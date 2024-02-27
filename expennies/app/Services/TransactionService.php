<?php

namespace App\Services;

use App\DataObjects\TransactionData;
use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

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

}
