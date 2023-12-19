<?php

  declare(strict_types=1);

  namespace DIContainer\Services;

  use DIContainer\Interfaces\PaymentGatewayInterface;

  class InvoiceService {
    public function __construct( // constructor injection, loosely coupled
      protected SalesTaxService $salesTaxService,
      protected PaymentGatewayInterface $gatewayService,
      protected EmailService $emailService
    ) {}

    public function process(array $customer, float $amount): bool {
      // 1. calculate sales tax
      $tax = $this->salesTaxService->calculate($amount, $customer);

      // 2. process invoice
      if (!$this->gatewayService->charge($customer, $amount, $tax)) {
        return false;
      }

      // 3. send receipt
      $result = $this->emailService->send($customer, 'receipt');
      $result = $result ? 'successfully' : 'failed';

      echo "Invoice has been processed $result.<br/>";

      return true;
    }
  }
