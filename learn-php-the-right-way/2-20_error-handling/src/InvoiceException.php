<?php

  declare(strict_types=1);

  namespace ErrorHandling;

  use Exception;

  class InvoiceException extends Exception {
    public static function missingBillingInfo(): static {
      // return new MissingBillingInfoException();
      return new static('Missing billing info.');
    }

    public static function invalidAmount(): static {
      return new static('Invalid invoice amount.');
    }
  }
