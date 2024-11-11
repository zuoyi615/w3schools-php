<?php declare(strict_types=1);

  require_once './2.04-namespace-paddle0.php';
  require_once './2.04-namespace-paddle1.php';
  require_once './2.04-namespace-notification.php';
  require_once './2.04-namespace-stripe0.php';
  // require_once './2.24-namespace2.php';
  // var_dump(new PaymentGateway\Paddle\Transaction());
  // echo '<br />';
  // var_dump(new PaymentGateway\Stripe\Transaction());

  use PaymentGateway\Paddle\{Transaction, CustomerProfile};

  // use PaymentGateway\Paddle;
  // new Paddle\CustomerProfile();
  // new Paddle\Transaction();
  // new Paddle\DateTime();

  use PaymentGateway\Stripe\Transaction as T;

  var_dump(new Transaction());
  echo '<br>';
  var_dump(new T());
  echo '<br>';
  var_dump(new CustomerProfile());
