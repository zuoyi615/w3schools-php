<?php

  declare(strict_types=1);

  namespace MVCModels\Controllers;

  use MVCModels\Models\{User, Invoice, SignUp};
  use MVCModels\View;


  class HomeController {
    public function index(): View {
      $email  = 'test0001@example.com';
      $name   = 'Jon';
      $amount = 25;

      $user      = new User();
      $invoice   = new Invoice();
      $signUp    = new SignUp($user, $invoice);
      $invoiceId = $signUp->register(['email' => $email, 'name' => $name], ['amount' => $amount]);

      return View::make('index', ['invoice' => $invoice->find($invoiceId)]);
    }

    public function upload(): void {
      $avatar = $_FILES['avatar'];
      if (!isset($avatar) || !$avatar['tmp_name']) {
        echo 'No File: avatar';
        return;
      }

      $target = UPLOAD_PATH.DIRECTORY_SEPARATOR.$avatar['name'];
      move_uploaded_file($avatar['tmp_name'], $target);
      header('Location: /');
      exit;
    }

    public function download(): void {
      header('Content-Type: image/png');
      header('Content-Disposition: attachment; filename=avatar-test.png');
      readfile(UPLOAD_PATH.DIRECTORY_SEPARATOR.'avatar.png');
    }
  }
