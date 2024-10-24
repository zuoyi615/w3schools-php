<?php
  global $con;
  $host = '127.0.0.1';
  $user = 'root';
  $pass = '123456';
  $dbname = 'php_tutorial';

  try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $con->beginTransaction();
    $con->exec("INSERT INTO guests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')");
    $con->exec("INSERT INTO guests (firstname, lastname, email) VALUES ('Mary', 'Moe', 'mary@example.com')");
    $con->exec("INSERT INTO guests (firstname, lastname, email) VALUES ('Julie', 'Dooley', 'julie@example.com')");
    $con->commit();
    echo 'New records created successfully.';
  } catch (PDOException $e) {
    $con?->rollBack();
    echo 'Error' . $e->getMessage();
  } finally {
    $con = null;
  }
