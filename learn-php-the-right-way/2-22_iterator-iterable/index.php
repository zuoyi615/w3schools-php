<?php

  declare(strict_types=1);

  require_once 'vendor/autoload.php';

  use IteratorIterable\{Invoice, InvoiceCollection};

  // $invoice = new Invoice(100);
  // foreach ($invoice as $key => $value) { // public properties
  //   echo $key.': '.$value, PHP_EOL;
  // }

  $invoiceCollection = new InvoiceCollection([
    new Invoice(10),
    new Invoice(20),
    new Invoice(30),
  ]);

  foreach ($invoiceCollection as $invoice) {
    echo $invoice->id.' - '.$invoice->amount, PHP_EOL, PHP_EOL;
  }

  foo([1, 2, 3]);
  foo($invoiceCollection);
  // foo(1); // error

  function foo(iterable $iterable): void {
    foreach ($iterable as $key => $value) {
      echo $key, PHP_EOL;
    }
  }
