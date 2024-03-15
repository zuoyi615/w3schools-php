<?php

namespace App\Services;

use App\Contracts\EntityManagerServiceInterface;
use App\Entity\Receipt;
use App\Entity\Transaction;
use DateTime;

readonly class ReceiptService
{

    public function __construct(private EntityManagerServiceInterface $em) {}

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

        return $receipt;
    }

    public function getById(int $id): ?Receipt
    {
        return $this->em->getRepository(Receipt::class)->find($id);
    }

}
