<?php declare(strict_types=1) ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>select data</title>
  </head>
  <body>
    <?php
      include '../07-php-ajax/Rows.php';
      echo "<table style='border: solid 1px lightgray;text-align: left;padding: 12px; border-radius: 4px;'>";
      echo "<tr>
              <th style='padding: 4px 12px;'>Id</th>
              <th style='padding: 4px 12px;'>Firstname</th>
              <th style='padding: 4px 12px;'>Lastname</th>
              <th style='padding: 4px 12px;'>email</th>
            </tr>";

      $host = '127.0.0.1';
      $user = 'root';
      $pass = '123456';
      $dbname = 'php_tutorial';

      try {
        $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT id, firstname, lastname, email FROM guests';
        $stmt = $con->prepare($sql);
        $stmt->execute();
        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        foreach (new Rows(new RecursiveArrayIterator($result)) as $field => $value) {
          echo $value;
        }
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $con = null;
      }
      echo "</table>";
    ?>
  </body>
</html>
