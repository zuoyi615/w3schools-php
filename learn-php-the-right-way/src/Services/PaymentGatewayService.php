<?php

    declare(strict_types=1);

    namespace App\Services;

    use App\Interfaces\PaymentGatewayInterface;

    class PaymentGatewayService implements PaymentGatewayInterface
    {
        public function charge(array $customer, float $amount, float $tax): bool
        {
            // sleep(1);
            return true;
        }
    }
