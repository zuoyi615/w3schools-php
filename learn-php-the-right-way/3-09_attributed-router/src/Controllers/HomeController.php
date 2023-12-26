<?php

  declare(strict_types=1);

  namespace AttributedRouter\Controllers;

  use AttributedRouter\Services\InvoiceService;
  use AttributedRouter\View;
  use AttributedRouter\Attributes\Route;


  readonly class HomeController {
    public function __construct(private InvoiceService $invoiceService) {}

    #[Route('/')]
    public function index(): View {
      $this->invoiceService->process([], 25);
      return View::make('index');
    }
  }
