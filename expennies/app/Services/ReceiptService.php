<?php

namespace App\Services;

use App\Entity\Receipt;
use App\Entity\Transaction;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

readonly class ReceiptService
{
    public function __construct(private EntityManager $em) {}

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(
        Transaction $transaction,
        string      $filename,
        string      $storageFilename,
        string      $mediaType
    ): Receipt {
        $receipt = new Receipt();
        $receipt
            ->setTransaction($transaction)
            ->setFilename($filename)
            ->setStorageFilename($storageFilename)
            ->setMediaType($mediaType)
            ->setCreatedAt(new DateTime());

        $this->em->persist($receipt);
        $this->em->flush();

        return $receipt;
    }

    public function getById(int $id): ?Receipt
    {
        return $this->em->getRepository(Receipt::class)->find($id);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(int $id): void
    {
        $receipt = $this->em->getRepository(Receipt::class)->find($id);
        if ($receipt) {
            $this->em->remove($receipt);
            $this->em->flush();
        }
    }


}
