<?php declare(strict_types=1); ?>
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
    <a href="<?php $_SERVER['PHP_SELF'] ?>?subject=PHP&web=W3schools.com">Test $_GET</a>
    <?php
      /**
       * `$_GET`contains an array data received via the *HTTP GET* method
       * - Query strings in the URL
       * - HTML Forms by *GET* method
       */
      if (isset($_GET['subject'])) {
        echo '<br />';
        echo $_GET['subject'];
      }
      if (isset($_GET['web'])) {
        echo '<br />';
        echo $_GET['web'];
      }
    ?>
  </body>
</html>
