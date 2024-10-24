<?php declare(strict_types=1) ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>include main</title>
  </head>
  <body>
    <?php include_once './02-include-menu.php' ?>
    <h1>Welcome to my home page!</h1>
    <p>Some text.</p>
    <p>Some more text.</p>
    <?php
      /**
       * The only difference is that the include() statement generates a PHP alert but allows script execution to
       * proceed if the file to be included cannot be found. At the same time, the require() statement generates a
       * fatal error and terminates the script
       */

      // include './notExisted.php'; // this will raise a warning
      // require './notExisted.php'; // this will raise a warning
      include_once './02-include-vars.php';
      echo "I have a $color $car";
    ?>
    <?php include_once './02-include-footer.php' ?>
  </body>
</html>
