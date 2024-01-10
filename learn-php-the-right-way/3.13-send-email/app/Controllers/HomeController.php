<?php

  declare(strict_types=1);

  namespace SendEmail\Controllers;

  use SendEmail\Attributes\Get;
  use SendEmail\Attributes\Post;
  use SendEmail\Attributes\Put;
  use SendEmail\Attributes\Route;
  use SendEmail\Enums\HttpMethod;
  use SendEmail\Services\InvoiceService;
  use SendEmail\View;

  class HomeController {
    public function __construct(private InvoiceService $invoiceService) {}

    #[Get('/')]
    #[Route('/home', HttpMethod::Head)]
    public function index(): View {
      $this->invoiceService->process([], 25);

      return View::make('index');
    }

    #[Post('/')]
    public function store() {}

    #[Put('/')]
    public function update() {}
  }
