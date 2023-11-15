<?php

  declare(strict_types=1);

  namespace ObjectCloning;

  class Invoice {
    private string $id;

    public function __construct() {
      $this->id = uniqid('invoice_');
    }

    public static function create(): static {
      return new static();
    }

    public function __clone(): void {
      $this->id = uniqid('invoice_');
    }
  }
