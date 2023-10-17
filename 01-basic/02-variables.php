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
          $txt = 'W3Schools.com';
          $x = 5;
          $y = 10.5;
          echo "I love $txt !";
        ?>
      </li>
      <li>
        <?php
          echo $x + $y; // global scope
        ?>
      </li>
      <li>
        <?php
          function test(): void {
            $x = 55;
            echo "<p>Variable x inside function is: $x</p>";
          }

          test();
          echo "<p>Variable x outside function is: $x</p>";
        ?>
      </li>
      <li>
        <?php
          // $GLOBALS
          $x1 = 5;
          $y1 = 10;

          function my_test(): void {
            $GLOBALS['y1'] = $GLOBALS['x'] + $GLOBALS['y'];
          }

          my_test();
          echo $y1;
        ?>
      </li>
      <li>
        <?php
          {
            function my_test1(): void {
              static $x = 0;
              echo "<p>$x</p>";
              $x++;
            }

            my_test1();
            my_test1();
            my_test1();
          }
        ?>
      </li>
    </ul>
  </body>
</html>
