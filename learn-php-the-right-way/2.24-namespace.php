<?php declare(strict_types=1);
   require_once './2.24-namespace1.php';
  // require_once './2.24-namespace2.php';
  // var_dump(new PaymentGateway\Paddle\Transaction());
  // echo '<br />';
  // var_dump(new PaymentGateway\Stripe\Transaction());

  use PaymentGateway\Paddle\Transaction;
  var_dump(new Transaction());
