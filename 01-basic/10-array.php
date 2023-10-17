<?php declare(strict_types=1); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>array</title>
  </head>
  <body>
    <ul>
      <li>
        <?php
          $cars = ['Volvo', 'BMW', 'Toyota'];
          echo 'I like ' . $cars[0] . ', ' . $cars[1] . ' and ' . $cars[2];
        ?>
      </li>
      <li>
        <?php echo count($cars); ?>
      </li>
      <li>
        <?php
          // named index array
          $people = array("Peter" => "35", "Ben" => "37", "Joe" => "43");
          foreach ($people as $name => $age) {
            echo "key=$name, Value=$age";
            echo '<br />';
          }
        ?>
      </li>
      <li>
        <?php
          $cars = array("Volvo", "BMW", "Toyota");
          // sort($cars);
          rsort($cars);
          var_dump($cars);
          echo '<br />';
          $numbers = array(4, 6, 2, 22, 11);
          var_dump($numbers);
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
      $cars = array(
        array("Volvo", 22, 18),
        array("BMW", 15, 13),
        array("Saab", 5, 2),
        array("Land Rover", 17, 15)
      );

      for ($row = 0; $row < 4; $row++) {
        echo "<p><b>Row number $row</b></p>";
        echo "<ul>";
        for ($col = 0; $col < 3; $col++) {
          echo "<li>" . $cars[$row][$col] . "</li>";
        }
        echo "</ul>";
      }
    ?>
  </body>
</html>
