<?php

  declare(strict_types=1);

  use ObjectComparison\{Invoice, Customer};

  require_once 'vendor/autoload.php';

  $invoice01 = new Invoice(new Customer('One'), 100, 'Invoice');
  $invoice02 = new Invoice(new Customer('One'), 100, 'Invoice');
  $invoice03 = $invoice01;

  echo 'invoice01==invoice02'.PHP_EOL;
  var_dump($invoice01 == $invoice02); // true, recursively compare $customer
  echo 'invoice01===invoice02'.PHP_EOL;
  var_dump($invoice01 === $invoice02); // false
  echo 'invoice01===invoice03'.PHP_EOL;
  var_dump($invoice01 === $invoice03); // true
  $invoice03->setAmount(200);
  var_dump($invoice01);
