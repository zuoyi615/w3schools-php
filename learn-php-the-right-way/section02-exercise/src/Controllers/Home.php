<?php

  declare(strict_types=1);

  namespace Exercise02\Controllers;

  use Exercise02\View;

  class Home {
    public function index(): View {
      return View::make('index');
    }

    public function upload(): void {
      echo 'Upload';
    }

    public function transactions(): void {
      echo 'Transactions';
    }
  }
