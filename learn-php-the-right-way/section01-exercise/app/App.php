<?php
  declare(strict_types=1);

  function getTransactionFiles(string $dir): array {
    $files = [];
    foreach (scandir($dir) as $file) {
      if (is_dir($file)) continue;
      $files[] = $dir . $file;
    }
    return $files;
  }

  function getTransactions(string $filename, ?callable $transformer = null): array {
    if (!file_exists($filename)) trigger_error("File '$filename' does not exists", E_USER_ERROR);
    $file = fopen($filename, 'r');
    $transactions = [];
    fgetcsv($file);
    while (($transaction = fgetcsv($file)) !== false) {
      if ($transformer !== null) $transaction = $transformer($transaction);
      $transactions[] = $transaction;
    }
    return $transactions;
  }

  function extractTransaction(array $transaction): array {
    [$date, $checkNumber, $description, $amount] = $transaction;
    $amount = (float)str_replace(['$', ','], '', $amount);

    return [
      'date' => $date,
      'checkNumber' => $checkNumber,
      'description' => $description,
      'amount' => $amount
    ];
  }

  function calculateTotals(array $transactions): array {
    $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];
    foreach ($transactions as $transaction) {
      $amount = $transaction['amount'];
      $totals['netTotal'] += $amount;
      if ($amount >= 0) $totals['totalIncome'] += $amount;
      else $totals['totalExpense'] += $amount;

    }
    return $totals;
  }
