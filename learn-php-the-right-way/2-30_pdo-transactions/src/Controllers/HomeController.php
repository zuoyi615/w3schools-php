<?php

  declare(strict_types=1);

  namespace PDOTransactions\Controllers;

  use PDOException;
  use PDOTransactions\View;
  use PDO;

  class HomeController {
    public function index(): View {
      $host   = $_ENV['DB_HOST'];
      $dbname = $_ENV['DB_DATABASE'];
      $user   = $_ENV['DB_USER'];
      $pass   = $_ENV['DB_PASS'];
      $db     = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass, []);
      try {
        $db->beginTransaction();
        $guests = $db->query('SELECT * FROM guests LIMIT 2')->fetchAll();
        $db->commit();
        echo '<pre>';
        var_dump($guests);
        echo '</pre>';
      } catch (PDOException $e) {
        if ($db->inTransaction()) {
          $db->rollBack();
        }
        throw new PDOException($e->getMessage(), (int)$e->getCode());
      }
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
      header('Location: /');
      exit;
    }

    public function download(): void {
      header('Content-Type: image/png');
      header('Content-Disposition: attachment; filename=avatar-test.png');
      readfile(UPLOAD_PATH.DIRECTORY_SEPARATOR.'avatar.png');
    }
  }
