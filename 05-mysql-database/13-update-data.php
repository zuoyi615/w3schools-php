<?php
  $host = '127.0.0.1';
  $user = 'root';
  $pass = '123456';
  $dbname = 'php_tutorial';
  $sql = 'UPDATE guests SET lastname=\'Jack\' WHERE id=8';

  try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $con->prepare($sql);
    $stmt->execute();
    echo $stmt->rowCount() . ' Records UPDATED successfully.';
  } catch (PDOException $e) {
    echo $sql . "<br/>" . $e->getMessage();
  } finally {
    $con = null;
  }
