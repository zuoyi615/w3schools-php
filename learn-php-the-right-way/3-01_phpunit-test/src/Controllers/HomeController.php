<?php

  declare(strict_types=1);

  namespace PHPUnitTest\Controllers;

  use PHPUnitTest\View;

  class HomeController {
    public function index(): View {
      return View::make('index');
    }
  }
