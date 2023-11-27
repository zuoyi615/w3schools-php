<?php

  declare(strict_types=1);

  namespace MVCPattern\Controllers;

  use MVCPattern\Exceptions\ViewNotFoundException;
  use MVCPattern\View;

  class HomeController {
    /**
     * @throws ViewNotFoundException
     */
    public function index(): View {
      // return View::make('index')->render();
      // return (string)View::make('index');
      return View::make('index', ['foo' => 'bar']);
    }

    public function upload(): void {
      $avatar = $_FILES['avatar'];
      if (!isset($avatar) || !$avatar['tmp_name']) {
        echo 'No File: avatar';
        return;
      }

      move_uploaded_file($avatar['tmp_name'], UPLOAD_PATH.DIRECTORY_SEPARATOR.$avatar['name']);
      echo 'Uploaded Successfully';
    }
  }
