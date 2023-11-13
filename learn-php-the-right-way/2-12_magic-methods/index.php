<?php

  declare(strict_types=1);

  require_once 'vendor/autoload.php';

  use MagicMethods\Invoice;

  $invoice = new Invoice(15);

  $invoice->amount = 15;
  echo $invoice->amount, PHP_EOL;
  // echo "From instance: ", PHP_EOL, $invoice->amount, PHP_EOL;

  var_dump($invoice->count);
  $invoice->count = 20;
  var_dump($invoice->count);
  unset($invoice->count);

  $invoice->process(15, 'Desc 01');
  $invoice::superProcess(3, 2, 1);

  echo $invoice, PHP_EOL;
  var_dump($invoice instanceof Stringable); // true, because of the __toString() magic method

  $invoice();
  var_dump(is_callable($invoice)); // true, because of the __invoke() magic method

  echo PHP_EOL;
  var_dump($invoice);
