<?php
  $host = '127.0.0.1';
  $user = 'root';
  $pass = '123456';
  $dbname = 'php_tutorial';
  $sql = "INSERT INTO guests (firstname, lastname,email) VALUES ('Jane','Doe','john.doe@example.com')";

  try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->exec($sql);
    $last_id = $con->lastInsertId();
    echo "New record created successfully, Last inserted ID is: $last_id";
  } catch (PDOException $e) {
    echo $sql . "<br/>" . $e->getMessage();
  } finally {
    $con = null;
  }
