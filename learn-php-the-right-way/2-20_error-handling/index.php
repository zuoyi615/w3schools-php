<?php

  declare(strict_types=1);

  use ErrorHandling\{Invoice, Customer, InvoiceException, MissingBillingInfoException};

  require_once 'vendor/autoload.php';

  // global exception handler
  set_exception_handler(function (Throwable $e) {
    echo $e->getMessage();
  });

  $invoice = new Invoice(new Customer(['foo' => 'bar']));
  // $invoice->process(-1); // caught by global exception handler

  function main(Invoice $invoice): int {
    try {
      $invoice->process(-25);
      return 0;
    } catch (InvoiceException $e) {
      echo 'Error: '.$e->getMessage().' '.$e->getFile().':'.$e->getLine();
      return 3;
    } catch (MissingBillingInfoException $e) {
      echo 'BillingInfoError: '.$e->getMessage().' '.$e->getFile().':'.$e->getLine();
      return 1;
    } catch (InvalidArgumentException $e) {
      echo 'InvalidArgumentError: '.$e->getMessage().' '.$e->getFile().':'.$e->getLine();
      return 2;
    } finally {
      echo PHP_EOL, 'Finally Block', PHP_EOL;
      // return -1; // override the return value before finally block
    }
  }

  var_dump(main($invoice));
