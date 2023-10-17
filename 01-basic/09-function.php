<?php declare(strict_types=1); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>function</title>
  </head>
  <body>
    <ul>
      <li>
        <?php
          function addNumbers(int $a, int $b): int {
            return $a + $b;
          }

          // echo addNumbers(5, '5 days');
          echo addNumbers(5, 10) . '<br />';

          function setHeight(int $height = 50): void {
            echo "The height is: $height <br />";
          }

          setHeight(350);
          setHeight();
          setHeight(80);
          setHeight(135);


          function add_five(&$value): void {
            $value += 5;
          }

          $zero = 0;
          add_five($zero);
          // echo '<br />';
          echo $zero;
        ?>
      </li>
    </ul>
  </body>
</html>
