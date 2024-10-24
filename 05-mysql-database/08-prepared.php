<?php
  $host = '127.0.0.1';
  $user = 'root';
  $pass = '123456';
  $dbname = 'php_tutorial';

  try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'INSERT INTO guests (firstname, lastname,email) VALUES (:firstname, :lastname, :email)';
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);

    $firstname = 'John1';
    $lastname = 'Doe';
    $email = 'john1@example.com';
    $stmt->execute();

    $firstname = 'Mary1';
    $lastname = 'Moe';
    $email = 'mary1@example.com';
    $stmt->execute();

    $firstname = 'Julie1';
    $lastname = 'Dooley';
    $email = 'julie1@example.com';
    $stmt->execute();

    echo 'New records created successfully';
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  } finally {
    $con = null;
  }
