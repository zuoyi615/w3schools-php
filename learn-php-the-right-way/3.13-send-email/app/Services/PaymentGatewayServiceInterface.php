<?php

  declare(strict_types=1);

  namespace SendEmail\Services;

  interface PaymentGatewayServiceInterface {
    public function charge(array $customer, float $amount, float $tax): bool;
  }
