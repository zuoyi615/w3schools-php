<?php

  declare(strict_types=1);

  namespace IteratorIterable;

  class Invoice {
    public string $id;

    public function __construct(public float $amount) {
      $this->id = uniqid('invoice_');
    }
  }
