<?php

  declare(strict_types=1);

  namespace SendEmail\Services;

  class PaymentGatewayService implements PaymentGatewayServiceInterface {
    public function charge(array $customer, float $amount, float $tax): bool {
      //        sleep(1);

      return true; //mt_rand(0, 1);
    }
  }
