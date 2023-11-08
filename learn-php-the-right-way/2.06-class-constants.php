<?php

  declare(strict_types=1);

  namespace Constants;

  use InvalidArgumentException;

  class Transaction {
    private string $status;

    public function getStatus(): string {
      return $this->status;
    }

    public function __construct() {
      $this->status = Status::PENDING;
    }

    public function setStatus(string $status): self {
      if (!isset(Status::ALL_STATUSES[$status])) {
        throw new InvalidArgumentException();
      }

      $this->status = $status;
      return $this;
    }
  }

  $transaction = new Transaction();
  $transaction->setStatus(Status::PAID);
  var_dump($transaction->getStatus());
