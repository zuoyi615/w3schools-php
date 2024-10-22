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
          /**
           * Differences between `define()` and `const`
           * <p> the fundamental difference is that `const` defines constants at compile time,whereas `define` defines
           * them at runtime</p> [Link](https://stackoverflow.com/questions/2447791/php-define-vs-const)
           */

          // define('PI', 3.14); // old syntax, not recommend
          const BLACK = '#000000'; // not editable
          $color = BLACK;
          echo "<h2 style='background: $color;color: white;'>$color</h2>";
          // echo $GLOBALS['BLACK'] // error
          // $GLOBALS['PI'] = 321; // editable
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
