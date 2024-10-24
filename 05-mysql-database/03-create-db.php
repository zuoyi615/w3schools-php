<?php
  $host = '127.0.0.1';
  $user = 'root';
  $pass = '123456';

  $sql = 'CREATE DATABASE IF NOT EXISTS php_tutorial';
  try {
    $con = new PDO("mysql:host=$host", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->exec($sql); // no results are returned.
    echo 'Database created successfully.<br />';
  } catch (PDOException $e) {
    echo $sql . "<br/>" . $e->getMessage();
  } finally {
    $con = null;
  }
