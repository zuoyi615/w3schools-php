<?php

  declare(strict_types=1);

  namespace _SERVER\Classes;

  class Invoice {
    public function index(): string {
      return 'invoices';
    }

    public function create(): string {
      return 'Create Invoice';
    }
  }
