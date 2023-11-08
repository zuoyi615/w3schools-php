<?php

  declare(strict_types=1);

  namespace Encapsulation;

  use ReflectionProperty;

  class Transaction {
    public function __construct(private float $amount) {}

    public function getAmount(): float {
      return $this->amount;
    }

    public function process(): void {
      echo 'Processing'.$this->amount.' transaction';
      $this->generateReceipt();
      $this->sendEmail();
    }

    private function generateReceipt() {}

    private function sendEmail() {}
  }

  $transaction = new Transaction(100);
  // echo $transaction->amount; // error, because amount is private
  echo $transaction->getAmount();
  echo '<br >';
  echo $transaction->process();
  echo '<br >';

  $reflectProperty = new ReflectionProperty(Transaction::class, 'amount');
  $reflectProperty->setAccessible(true);
  echo $reflectProperty->getValue($transaction);
  echo '<br >';
  $reflectProperty->setValue($transaction, 200);
  echo $reflectProperty->getValue($transaction);
  echo '<br >';
  echo $transaction->getAmount();
