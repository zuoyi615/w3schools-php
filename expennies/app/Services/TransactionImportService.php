<?php

namespace App\Services;

use App\DataObjects\TransactionData;
use App\Entity\User;
use Clockwork\Clockwork;
use Clockwork\Request\LogLevel;
use DateTime;
use Doctrine\ORM\EntityManager;

readonly class TransactionImportService
{

    public function __construct(
        private CategoryService    $categoryService,
        private Clockwork          $clockwork,
        private EntityManager      $em,
        private TransactionService $transactionService,
    ) {}

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Exception
     */
    public
    function importFromCSV(
        string $path,
        User   $user
    ): void {
        $resource   = fopen($path, 'r');
        $categories = $this->categoryService->getAllKeyedByName();

        fgetcsv($resource); // first line is fields columns

        $this->clockwork->log(LogLevel::DEBUG, 'Memory Usage Before: '.memory_get_usage());
        $this->clockwork->log(LogLevel::DEBUG, 'Unit Of Work Before: '.$this->em->getUnitOfWork()->size());

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
                $this->em->flush();
                $this->em->clear();
                $count = 1;
            } else {
                $count++;
            }
        }

        if ($count > 1) {
            $this->em->flush();
            $this->em->clear();
        }

        $this->clockwork->log(LogLevel::DEBUG, 'Memory Usage After: '.memory_get_usage());
        $this->clockwork->log(LogLevel::DEBUG, 'Unit Of Work After: '.$this->em->getUnitOfWork()->size());
    }

}
