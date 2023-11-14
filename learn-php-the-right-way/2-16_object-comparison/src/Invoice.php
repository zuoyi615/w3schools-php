<?php

  namespace ObjectComparison;

  class Invoice {
    public function __construct(private Customer $customer, private float $amount, private string $desc) {}

    public function setAmount(float $amount): void {
      $this->amount = $amount;
    }

    public function setDesc(string $desc): void {
      $this->desc = $desc;
    }
  }
