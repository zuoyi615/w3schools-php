<?php
  $host = '192.168.1.18';
  $user = 'root';
  $pass = '123456';
  $dbname = 'php_tutorial';
  $sql = "INSERT INTO guests (firstname, lastname,email) VALUES ('John','Doe','john@example.com')";

  try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->exec($sql); // no results are returned.
    echo 'New record created successfully.';
  } catch (PDOException $e) {
    echo $sql . "<br/>" . $e->getMessage();
  } finally {
    $con = null;
  }
