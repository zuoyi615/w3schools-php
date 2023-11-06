<?php declare(strict_types=1);

  namespace NullsafeOperator;

  class PaymentProfile {
    public int $id;

    public function __construct() {
      $this->id = rand();
    }
  }

  class Customer {
    private ?PaymentProfile $paymentProfile = null;

    public function getPaymentProfile(): ?PaymentProfile {
      return $this->paymentProfile;
    }
  }

  class Transaction {
    private ?Customer $customer = null;

    public function getCustomer(): ?Customer {
      return $this->customer;
    }

    public function __construct(private readonly float $amount, private readonly string $description) {}

    public function getAmount(): float {
      return $this->amount;
    }

    public function getDescription(): string {
      return $this->description;
    }
  }

  $transaction = new Transaction(5, 'Transaction 01');
  echo $transaction->getCustomer()?->getPaymentProfile()?->id ?? 'Foo';
  // echo $transaction->getCustomer()->getPaymentProfile()->id ?? 'Foo'; // not work
  echo '<br />';
  echo var_dump($transaction->getCustomer()?->getPaymentProfile()?->id);
