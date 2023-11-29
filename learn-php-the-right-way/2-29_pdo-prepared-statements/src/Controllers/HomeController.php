<?php

  declare(strict_types=1);

  namespace PDOPreparedStatements\Controllers;

  use PDOException;
  use PDOPreparedStatements\View;
  use PDO;

  class HomeController {
    public function index(): View {
      try {
        // $db    = new PDO('mysql:host=192.168.1.18;dbname=learn_php_the_right_way', 'root', '123456',);
        $db = new PDO(
          'mysql:host=192.168.1.18;dbname=php_tutorial',
          'root',
          '123456',
          []
        );
        // $query = 'SELECT * FROM guests WHERE id=?';
        // $query = 'INSERT INTO guests (firstname,lastname,email) VALUES (?,?,?)';
        $query = 'INSERT INTO guests (firstname,lastname,email) VALUES (:firstname,:lastname,:email)';
        $stmt  = $db->prepare($query);
        // $stmt->bindValue('firstname', 'Zoe');
        // $stmt->bindValue('lastname', 'K');
        // $stmt->bindValue('email', 'king@example.com');
        $firstname = 'Orange';
        $lastname  = 'Green';
        $email     = 'orange@green.com';

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $firstname = 'Orange01';
        $lastname  = 'Green01';
        $email     = 'orange01@green01.com';
        $stmt->execute();

        $firstname = 'Orange02';
        $lastname  = 'Green02';
        $email     = 'orange02@green02.com';
        $stmt->execute();

        $firstname = 'Orange03';
        $lastname  = 'Green03';
        $email     = 'orange03@green03.com';
        $stmt->execute();

        // $stmt->execute([
        //  'email'     => 'dom@321.com',
        //  'firstname' => 'Jack',
        //  'lastname'  => 'T'
        // ]);
        $id    = $db->lastInsertId();
        $guest = $db->query('SELECT * FROM guests WHERE id='.$id)->fetch();
        echo '<pre>';
        var_dump($guest);
        echo '</pre>';
      } catch (PDOException $e) {
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
