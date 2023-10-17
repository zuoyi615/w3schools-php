<?php declare(strict_types=1) ?>
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
          echo $_SERVER['PHP_SELF'];
          echo '<br />';
          echo $_SERVER['SERVER_NAME'];
          echo '<br />';
          echo $_SERVER['HTTP_HOST'];
          echo '<br />';
          if (isset($_SERVER['HTTP_REFERER'])) {
            echo $_SERVER['HTTP_REFERER'];
            echo '<br />';
          }
          echo $_SERVER['HTTP_USER_AGENT'];
          echo '<br />';
          echo $_SERVER['SCRIPT_NAME'];
          echo '<br />';
          echo $_SERVER['SERVER_PORT'];
          echo '<br />';
          echo $_SERVER['SERVER_PROTOCOL'];
          echo '<br />';
          echo $_SERVER['REQUEST_METHOD'];
          echo '<br />';
        ?>
      </li>
    </ul>
  </body>
</html>
