<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
  </head>
  <body>
    <ul>
      <li>
        <?php
          // define('PI', 3.14); // old syntax, not recommend
          const BLACK = '#000000';
          $color = BLACK;
          echo "<h2 style='background: $color;color: white;'>$color</h2>";
          // echo $GLOBALS['BLACK'] // error
          // echo $GLOBALS['PI'];
        ?>
      </li>
      <li>
        <?php
          const COLORS = ['#ff000', '#00ff00', '#0000ff'];
          echo COLORS[0];
        ?>
      </li>
    </ul>
  </body>
</html>
