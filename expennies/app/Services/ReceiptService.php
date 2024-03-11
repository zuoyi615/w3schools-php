<?php

namespace App\Services;

use App\Entity\Receipt;
use App\Entity\Transaction;
use DateTime;

class ReceiptService extends EntityManagerService
{

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

        return $receipt;
    }

    public function getById(int $id): ?Receipt
    {
        return $this->em->getRepository(Receipt::class)->find($id);
    }

    public function delete(int $id): void
    {
        $receipt = $this->em->getRepository(Receipt::class)->find($id);
        if ($receipt) {
            $this->em->remove($receipt);
        }
    }

}
