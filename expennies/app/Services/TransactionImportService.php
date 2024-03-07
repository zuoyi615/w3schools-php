<?php

namespace App\Services;

use App\DataObjects\TransactionData;
use App\Entity\Transaction;
use App\Entity\User;
use DateTime;

readonly class TransactionImportService
{

    public function __construct(
        private CategoryService    $categoryService,
        private TransactionService $transactionService,
    ) {}

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public
    function importFromCSV(
        string $path,
        User   $user
    ): void {
        $resource   = fopen($path, 'r');
        $categories = $this->categoryService->getAllKeyedByName();

        fgetcsv($resource);

        $count     = 0;
        $batchSize = 250;
        while (($row = fgetcsv($resource)) !== false) {
            [$date, $description, $categoryName, $amount] = $row;

            $date     = new DateTime($date);
            $category = $categories[strtolower($categoryName)] ?? null;
            $amount   = (float) str_replace(['$', ','], '', $amount);

            $transactionData = new TransactionData(
                description: $description,
                amount     : $amount,
                date       : $date,
                category   : $category,
            );

            $this->transactionService->create($transactionData, $user);

            if ($count % $batchSize === 0) {
                $this->transactionService->flush();
                $this->transactionService->clear(Transaction::class);
                $count = 1;
            } else {
                $count++;
            }
        }

        if ($count > 1) {
            $this->transactionService->flush();
            $this->transactionService->clear();
        }
    }

}
