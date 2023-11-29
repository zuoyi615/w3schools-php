<?php

  declare(strict_types=1);

  namespace PDOPreparedStatements\Controllers;

  use PDOException;
  use PDOPreparedStatements\Exceptions\ViewNotFoundException;
  use PDOPreparedStatements\View;
  use PDO;

  class HomeController {
    /**
     * @throws ViewNotFoundException
     */
    public function index(): View {
      try {
        // $db    = new PDO('mysql:host=192.168.1.18;dbname=learn_php_the_right_way', 'root', '123456',);
        $db    = new PDO(
          'mysql:host=192.168.1.18;dbname=php_tutorial',
          'root',
          '123456',
          [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,      // fetch each row as php standard object
            // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // associative array
            // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS, // related to a class
          ]
        );
        $query = 'SELECT * FROM guests';
        $stmt  = $db->query($query);
        // $list  = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($stmt as $guest) {
          echo '<pre>';
          var_dump($guest);
          echo '</pre>';
        }
      } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), $e->getCode());
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
