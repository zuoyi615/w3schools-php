<?php
  $host = '192.168.1.18';
  $user = 'root';
  $pass = '123456';
  $dbname = 'php_tutorial';
  $sql = "CREATE TABLE IF NOT EXISTS guests (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      firstname VARCHAR(30) NOT NULL,
      lastname VARCHAR(30) NOT NULL,
      email VARCHAR(50),
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

  try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->exec($sql); // no results are returned.
    echo 'Table \'guests\' created successfully.<br />';
  } catch (PDOException $e) {
    echo $sql . "<br/>" . $e->getMessage();
  } finally {
    $con = null;
  }
