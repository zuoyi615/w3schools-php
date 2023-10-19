<?php declare(strict_types=1) ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>order by</title>
  </head>
  <body>
    <?php
      echo "<table style='border: solid 1px lightgray;text-align: left;padding: 12px; border-radius: 4px;'>";
      echo "<tr>
              <th style='padding: 4px 12px;'>Id</th>
              <th style='padding: 4px 12px;'>Firstname</th>
              <th style='padding: 4px 12px;'>Lastname</th>
              <th style='padding: 4px 12px;'>email</th>
            </tr>";

      class TableRows extends RecursiveIteratorIterator {
        function __construct(Traversable $iterator) {
          parent::__construct($iterator);
        }

        function current(): string {
          return '<td style="width: 150px;padding: 4px 12px;">' . parent::current() . '</td>';
        }

        function beginChildren(): void {
          echo '<tr>';
        }

        function endChildren(): void {
          echo '</tr>';
        }
      }

      // $host = '192.168.1.18'
      $host = 'localhost';
      $user = 'root';
      $pass = '123456';
      $dbname = 'php_tutorial';

      try {
        $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $con->prepare('SELECT id, firstname, lastname, email FROM guests ORDER BY lastname DESC');
        $stmt->execute();
        $results = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $field => $value) {
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
