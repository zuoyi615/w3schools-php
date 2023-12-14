<?php

  declare(strict_types=1);

  namespace PHPUnitMocking\Controllers;

  use PHPUnitMocking\View;

  class HomeController {
    public function index(): View {
      return View::make('index');
    }
  }
