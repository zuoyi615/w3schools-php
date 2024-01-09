<?php

  declare(strict_types=1);

  namespace SendEmail\Services;

  class SalesTaxService {
    public function calculate(float $amount, array $customer): float {
      //        sleep(1);

      return $amount * 6.5 / 100;
    }
  }
