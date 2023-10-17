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
        <h3>
          <?php
            $txt = 'PHP is the best programming language in the world.';
            $color = 'red';
            echo 'My car is ' . $color . '<br>';
            echo "My car is $color<br>";
            // ECHO 'My car is ' . $color . '<br>';
            // Echo 'My car is ' . $color . '<br>';
            echo $txt;
          ?>
        </h3>
      </li>
      <li>
        <?php
          $x = 5 + 5;
          echo $x;
        ?>
      </li>
      <li><?php phpinfo(); ?></li>
    </ul>
  </body>
</html>
