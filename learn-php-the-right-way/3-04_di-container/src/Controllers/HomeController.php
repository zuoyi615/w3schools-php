<?php

  declare(strict_types=1);

  namespace DIContainer\Controllers;

  use DIContainer\Services\InvoiceService;
  use DIContainer\View;

  readonly class HomeController {
    public function __construct(private InvoiceService $invoiceService) {}

    public function index(): View {
      $this->invoiceService->process([], 25);
      return View::make('index');
    }
  }
