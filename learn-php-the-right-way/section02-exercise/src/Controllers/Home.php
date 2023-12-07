<?php

  declare(strict_types=1);

  namespace Exercise02\Controllers;

  use Exercise02\Exceptions\FileNotFoundException;
  use Exercise02\Exceptions\FileNotUploadedException;
  use Exercise02\Models\Transaction;
  use Exercise02\View;

  class Home {
    public function index(): View {
      return View::make('index');
    }

    /**
     * @throws FileNotUploadedException
     */
    public function upload(): void {
      $file = $_FILES['file'];
      if (!isset($file)) {
        throw new FileNotUploadedException();
      }

      $filename = UPLOAD_PATH.DIRECTORY_SEPARATOR.$file['name'];
      move_uploaded_file($file['tmp_name'], $filename);
      header('Location: /transactions');
    }

    /**
     * @throws FileNotFoundException
     */
    public function transactions(): View {
      $transactionModel = new Transaction();
      $files            = Transaction::scan(UPLOAD_PATH);
      $transactionModel->loadAll($files);
      $transactions = $transactionModel->getTransactions();
      return View::make('transactions', [
        'transactions'       => $transactions,
        'totals'             => $transactionModel->calculateTotals(),
        'formatDollarAmount' => function (float $amount): string {
          $isNegative = $amount < 0;
          return ($isNegative ? '-' : '').'$'.number_format(abs($amount), 2);
        },
        'formatDate'         => function (string $time): string {
          return date('Y/m/d', strtotime($time));
        }
      ]);
    }
  }
