<?php

  declare(strict_types=1);

  namespace PDOTransactions\Controllers;

  use PDOTransactions\Exceptions\ViewNotFoundException;
  use PDOTransactions\View;

  class InvoiceController {
    /**
     * @throws ViewNotFoundException
     */
    public function index(): string {
      return View::make('invoices/index')->render();
    }

    /**
     * @throws ViewNotFoundException
     */
    public function create(): string {
      return View::make('invoices/create')->render();
    }

    public function store(): void {
      $amount = $_POST['amount'];
      if (isset($amount)) {
        echo "amount: $amount";
      }
    }
  }
