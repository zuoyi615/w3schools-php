<?php
  declare(strict_types=1);

  class Transaction {
    public function __construct(private float $amount, public string $description) {}

    public function addTax(float $rate): Transaction {
      $this->amount += $this->amount * $rate / 100;
      return $this;
    }

    public function applyDiscount(float $rate): Transaction {
      $this->amount -= $this->amount * $rate / 100;
      return $this;
    }

    public function getAmount(): float {
      return $this->amount;
    }

    public function __destruct() {
      echo $this->description . ' Destructed';
    }
  }

  // $class       = 'Transaction'; // variable class
  // $transaction = new $class(100, 'Transaction 01');
  // var_dump($transaction->amount); // fatal error before initializing
  $amount1 = (new Transaction(100, 'Transaction 01'))
    ->addTax(10)
    ->applyDiscount(8)
    ->getAmount();
  echo PHP_EOL;
  var_dump($amount1);

  $amount2 = (new Transaction(200, 'Transaction 02'))
    ->addTax(10)
    ->applyDiscount(8)
    ->getAmount();
  echo PHP_EOL;
  var_dump($amount2);
