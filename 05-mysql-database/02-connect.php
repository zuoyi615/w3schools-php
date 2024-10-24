<?php
  $host = '127.0.0.1';
  $user = 'root';
  $pass = '123456';

  try {
    $connection = new PDO("mysql:host=$host;dbname=php_tutorial", $user, $pass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connected successfully';
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
  } finally {
    $connection = null;
  }
  //  $servername = "localhost";
  //  $username = "username";
  //  $password = "password";
  //
  //  $conn = new mysqli($servername, $username, $password);
  //  if ($conn->connect_error) {
  //    die("Connection failed: " . $conn->connect_error);
  //  }
  //  echo "Connected successfully";
