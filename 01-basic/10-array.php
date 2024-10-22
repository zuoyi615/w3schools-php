<?php

  declare(strict_types=1); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>array</title>
    <style>
    code {
      background: gainsboro;
    }
    </style>
  </head>
  <body>
    <ul>
      <li>sort() sort arrays in ascending order</li>
      <li>rsort() sort arrays in descending order</li>
      <li>asort() sort associative arrays in ascending order, according to the value</li>
      <li>arsort() sort associative arrays in descending order, according to the value</li>
      <li>ksort() sort associative arrays in ascending order, according to the key</li>
      <li>krsort() sort associative arrays in descending order, according to the key</li>
      <li></li>
      <li>
        <?php
          $cars = ['Volvo', 'BMW', 'Toyota'];
          echo 'I like '.$cars[0].', '.$cars[1].' and '.$cars[2];
        ?>
      </li>
      <li>
        <?php
          echo count($cars); ?>
      </li>
      <li>
        <?php
          // named index array
          // $people = array("Peter" => "35", "Ben" => "37", "Joe" => "43");
          $people = ["Peter" => "35", "Ben" => "37", "Joe" => "43"];
          foreach ($people as $name => $age) {
            echo "key=$name, Value=$age";
            echo '<br />';
          }
        ?>
      </li>
      <li>
        <?php
          $cars = ["Volvo", "BMW", "Toyota"];
          // sort($cars);
          rsort($cars);
          var_dump($cars);
          echo '<br />';
          $numbers = [4, 6, 2, 22, 11];
          echo '<code>$numbers = [4, 6, 2, 22, 11]</code>';

          sort($numbers);
          var_dump($numbers);
          echo '<br />';
          rsort($numbers);
          var_dump($numbers);
          echo '<br />';
          asort($people);
          var_dump($people);
          echo '<br />';
          ksort($people);
          var_dump($people);
        ?>
      </li>
    </ul>
    <?php
      $cars = [
        ["Volvo", 22, 18],
        ["BMW", 15, 13],
        ["Saab", 5, 2],
        ["Land Rover", 17, 15],
      ];

      for ($row = 0; $row < count($cars); $row++) {
        echo "<p><b>Row number $row</b></p>";
        echo "<ul>";
        for ($col = 0; $col < 3; $col++) {
          echo "<li>".$cars[$row][$col]."</li>";
        }
        echo "</ul>";
      }
    ?>
  </body>
</html>
