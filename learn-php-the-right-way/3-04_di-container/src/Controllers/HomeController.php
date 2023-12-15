<?php

  declare(strict_types=1);

  namespace DIContainer\Controllers;

  use DIContainer\App;
  use DIContainer\Container;
  use DIContainer\Exceptions\Container\ContainerException;
  use DIContainer\Services\InvoiceService;
  use DIContainer\View;

  class HomeController {
    /**
     * @throws \ReflectionException
     * @throws ContainerException
     */
    public function index(): View {
      (new Container())->get(InvoiceService::class)->process([], 25);
      return View::make('index');
    }
  }
