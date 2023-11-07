<?php declare(strict_types=1);

  namespace PaymentGateway\Paddle;

  // from global
  use DateTime;
  use Notification\Email;
  use function explode;

  // use PaymentGateway\Paddle\DateTime; // from Paddle

  class Transaction {
    public function __construct() {
      var_dump(new CustomerProfile()); // CustomerProfile auto loaded in current same namespace
      echo '<br>';
      // new \DateTime(); // \Datetime from global namespace; recommended 'use DateTime;'
      var_dump(new DateTime());
      echo '<br>';
      var_dump(new Email());
      echo '<br>';
      var_dump(explode(',', 'Hello,World'));
      echo '<br>';
    }
  }
