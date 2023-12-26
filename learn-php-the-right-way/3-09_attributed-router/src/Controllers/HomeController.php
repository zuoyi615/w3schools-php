<?php

  declare(strict_types=1);

  namespace AttributedRouter\Controllers;

  use AttributedRouter\Attributes\{Get, Post, Put};
  use AttributedRouter\Services\InvoiceService;
  use AttributedRouter\View;

  readonly class HomeController {
    public function __construct(private InvoiceService $invoiceService) {}

    #[Get('/')]
    public function index(): View {
      $this->invoiceService->process([], 25);
      return View::make('index');
    }

    #[Post('/')]
    public function store(): void {
      echo 'stored successfully';
    }

    #[Put('/')]
    public function update(): void {
      echo 'updated successfully';
    }
  }
