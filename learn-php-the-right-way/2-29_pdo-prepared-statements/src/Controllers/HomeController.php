<?php

  declare(strict_types=1);

  namespace PDOPreparedStatements\Controllers;

  use PDOPreparedStatements\Exceptions\ViewNotFoundException;
  use PDOPreparedStatements\View;

  class HomeController {
    /**
     * @throws ViewNotFoundException
     */
    public function index(): View {
      // return View::make('index')->render();
      // return (string)View::make('index');
      return View::make('index', ['foo' => 'bar', 'name' => 'Jon', 'age' => 16]);
    }

    public function upload(): void {
      $avatar = $_FILES['avatar'];
      if (!isset($avatar) || !$avatar['tmp_name']) {
        echo 'No File: avatar';
        return;
      }

      $target = UPLOAD_PATH.DIRECTORY_SEPARATOR.$avatar['name'];
      move_uploaded_file($avatar['tmp_name'], $target);
      // echo 'Uploaded Successfully';
      header('Location: /'); // status code: 302, do not stop the script
      exit; // stop the script manually
      unlink($target); // if exit exists, this line would not execute
    }

    public function download(): void {
      header('Content-Type: image/png');
      header('Content-Disposition: attachment; filename=avatar-test.png');
      readfile(UPLOAD_PATH.DIRECTORY_SEPARATOR.'avatar.png');
    }
  }
