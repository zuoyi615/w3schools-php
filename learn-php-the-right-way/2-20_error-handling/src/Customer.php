<?php

  declare(strict_types=1);

  namespace ErrorHandling;

  class Customer {
    public function __construct(private readonly array $billingInfo = []) {}

    public function getBillingInfo(): array {
      return $this->billingInfo;
    }
  }
