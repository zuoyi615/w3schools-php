<?php

  declare(strict_types=1);

  namespace DIContainer\Controllers;

  use DIContainer\App;
  use DIContainer\Services\InvoiceService;
  use DIContainer\View;

  class HomeController {
    public function index(): View {
      App::container()->get(InvoiceService::class)->process([], 25);
      return View::make('index');
    }
  }
