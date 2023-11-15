<?php

  declare(strict_types=1);

  use ObjectCloning\Invoice;

  require_once 'vendor/autoload.php';

  $invoice01 = new Invoice();
  $invoice02 = new $invoice01();
  $invoice03 = Invoice::create();
  $invoice04 = clone $invoice01;

  var_dump($invoice01, $invoice02, $invoice03, $invoice04);
