<?php

  declare(strict_types=1);

  namespace Exercise02\Models;

  use Exercise02\Exceptions\FileNotFoundException;

  class Transaction extends Model {
    private array $transactions = [];

    public function __construct() {
      parent::__construct();
    }

    public function getTransactions(): array {
      return $this->transactions;
    }

    public static function scan(string $dir): array {
      $files = [];
      foreach (scandir($dir) as $file) {
        if (is_dir($file)) {
          continue;
        }
        $files[] = $dir.DIRECTORY_SEPARATOR.$file;
      }

      return $files;
    }

    /**
     * @throws FileNotFoundException
     */
    private function loadTransactionsFromFile(string $filename): array {
      if (!file_exists($filename)) {
        throw new FileNotFoundException();
      }

      $transactions = [];
      $file         = fopen($filename, 'r');

      fgetcsv($file);
      while (($transaction = fgetcsv($file)) !== false) {
        $transaction    = static::extractTransaction($transaction);
        $transactions[] = $transaction;
      }

      return $transactions;
    }

    /**
     * @throws FileNotFoundException
     */
    public function loadAll(array $files): void {
      foreach ($files as $file) {
        $this->transactions = array_merge(
          $this->transactions,
          $this->loadTransactionsFromFile($file)
        );
      }
    }

    private static function extractTransaction(array $transaction): array {
      [$date, $checkNumber, $description, $amount] = $transaction;
      $amount = (float)str_replace(['$', ','], '', $amount);

      return [
        'date'        => $date,
        'checkNumber' => $checkNumber,
        'description' => $description,
        'amount'      => $amount
      ];
    }

    public function calculateTotals(): array {
      $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];
      foreach ($this->transactions as $transaction) {
        $amount             = $transaction['amount'];
        $totals['netTotal'] += $amount;
        if ($amount >= 0) {
          $totals['totalIncome'] += $amount;
        } else {
          $totals['totalExpense'] += $amount;
        }
      }
      return $totals;
    }
  }
