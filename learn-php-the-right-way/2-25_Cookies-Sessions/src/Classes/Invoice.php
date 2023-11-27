<?php

  declare(strict_types=1);

  namespace CookieSession\Classes;

  class Invoice {
    public function index(): string {
      unset($_SESSION['count']);
      setcookie(
        'name',
        'Jon',
        time() - (24 * 60 * 60),
        '/',
        '',
        false,
        false,
      );
      return 'invoices';
    }

    public function create(): string {
      return (
      <<<Form
          <form method="post" action="/invoices">
            <div>
              <label for="amount">Amount</label>
              <input id="amount" type="text" name="amount" />
              <input type="submit" />
            </div>
          </form>
        Form
      );
    }

    public function store(): void {
      $amount = $_POST['amount'];
      if (isset($amount)) {
        echo "amount: $amount";
      }
    }
  }
