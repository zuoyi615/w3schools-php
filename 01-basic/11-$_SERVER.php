<?php

  declare(strict_types=1) ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    code {
      background: gainsboro;
    }
    </style>
  </head>
  <body>
    <?php
      echo '<code>$_SERVER[\'PHP_SELF\']</code> : ', $_SERVER['PHP_SELF'];
      echo '<br />';
      echo '<code>$_SERVER[\'SERVER_NAME\']</code> : ', $_SERVER['SERVER_NAME'];
      echo '<br />';
      echo '<code>$_SERVER[\'HTTP_HOST\']</code> : ', $_SERVER['HTTP_HOST'];
      echo '<br />';
      if (isset($_SERVER['HTTP_REFERER'])) {
        echo '<code>$_SERVER[\'HTTP_REFERER\']</code> : ', $_SERVER['HTTP_REFERER'];
        echo '<br />';
      }
      echo '<code>$_SERVER[\'HTTP_USER_AGENT\']</code> : ', $_SERVER['HTTP_USER_AGENT'];
      echo '<br />';
      echo '<code>$_SERVER[\'SCRIPT_NAME\']</code> : ', $_SERVER['SCRIPT_NAME'];
      echo '<br />';
      echo '<code>$_SERVER[\'SERVER_PORT\']</code> : ', $_SERVER['SERVER_PORT'];
      echo '<br />';
      echo '<code>$_SERVER[\'/SERVER_PROTOCOL\']</code> : ', $_SERVER['SERVER_PROTOCOL'];
      echo '<br />';
      echo '<code>$_SERVER[\'REQUEST_METHOD\']</code> : ', $_SERVER['REQUEST_METHOD'];
      echo '<br />';
    ?>
  </body>
</html>
