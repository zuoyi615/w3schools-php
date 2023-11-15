<?php

  declare(strict_types=1);

  namespace SerializeObjects;

  class Invoice {
    public string $id;

    public function __construct(
      public float $amount,
      public string $description,
      public string $creditCardNumber
    ) {
      $this->id = uniqid('invoice_');
    }

    public function __sleep(): array {
      return ['id', 'amount']; // names of the properties that we want to serialize
    }

    public function __wakeup(): void {}

    public function __serialize(): array { // high precedence
      return [
        'id'               => $this->id,
        'amount'           => $this->amount,
        'description'      => $this->description,
        'creditCardNumber' => base64_encode($this->creditCardNumber),
        'foo'              => 'bar'
      ];
    }

    public function __unserialize(array $data): void { // high precedence
      $this->id               = $data['id'];
      $this->amount           = $data['amount'];
      $this->description      = $data['description'];
      $this->creditCardNumber = base64_decode($data['creditCardNumber']);
      var_dump($data);
    }

    // __serialize and __unserialize are more powerful than Serializable interface and __sleep() __wakeup()
  }
