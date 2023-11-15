<?php

  declare(strict_types=1);

  namespace ErrorHandling;

  use InvalidArgumentException;

  class Invoice {
    public function __construct(public Customer $customer) {}

    /**
     * @throws InvalidArgumentException
     * @throws InvoiceException
     */
    public function process(float $amount): void {
      if ($amount <= 0) {
        // throw new InvalidArgumentException('Invalid invoice amount.');
        throw InvoiceException::invalidAmount();
      }

      if (empty($this->customer->getBillingInfo())) {
        // throw new MissingBillingInfoException();
        throw InvoiceException::missingBillingInfo();
      }

      echo 'Processing $'.$amount.' invoice - ';
      sleep(1);
      echo 'OK', PHP_EOL;
    }
  }
