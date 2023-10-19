<?php
  // $host = '192.168.1.18';
  $host = 'localhost';
  $user = 'root';
  $pass = '123456';
  $dbname = 'php_tutorial';
  $sql = "DELETE FROM guests WHERE id=1";

  try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $con->prepare($sql);
    $stmt->execute();
    echo 'Record deleted successfully.';
  } catch (PDOException $e) {
    echo $sql . "<br/>" . $e->getMessage();
  } finally {
    $con = null;
  }
