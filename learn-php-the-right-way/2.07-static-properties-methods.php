<?php

  declare(strict_types=1);

  namespace Static;

  class Transaction {
    // public static int $count = 8;
    private static int $count = 0;

    public static function getCount(): int {
      // return $this->amount; // error
      return self::$count;
    }

    public static function setCount(int $count): void {
      self::$count = $count;
    }

    public function __construct(public float $amount, public string $description) {}

    public function process(): void {
      self::$count++;
      // array_map(static function () {
      // return $this->amount; // error, can not get $this from static callback
      // }, [1]);
      // array_map(function () {
      //  var_dump($this->amount);
      // }, [1]);
    }
  }

  //  $transaction = new Transaction(100, 'Transaction 01');
  //  echo $transaction::$count;
  //  echo '<br>';
  //  echo Transaction::$count;
  //  echo '<br>';
  //  $transaction->process();
  //  echo $transaction::$count;
  //  echo '<br>';
  //  echo Transaction::$count;

  $transaction = new Transaction(100, 'Transaction 01');
  echo $transaction::getCount();
  $transaction->process();
  echo '<br>';
  echo $transaction::getCount();
  // echo '<br>';
  // echo $transaction->getCount(); // not recommend, confusing
  $transaction::setCount(100);
  echo '<br>';
  echo $transaction::getCount();
