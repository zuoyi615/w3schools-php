<?php
  declare(strict_types=1);
  $name = 'user';
  $value = 'John Doe';
  setcookie($name, $value, time() + (60 * 60 * 24 * 30), '/'); // recommended: appear before <html> tag
  // setrawcookie(); prevent URLencoding
  // setcookie(): set, modify
  // setcookie('user', '', time()-3600); // delete
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>cookie</title>
  </head>
  <body>
    <?php
      if (!isset($_COOKIE[$name])) {
        echo "Cookie named '$name' is not set.";
        return;
      }
      echo "Cookie named '$name' is set.<br/>";
      echo "Value is: $_COOKIE[$name]<br/>";

      // Check if Cookies are enabled
      if (count($_COOKIE) > 0) {
        echo 'Cookies are enabled.';
        return;
      }
      echo 'Cookies are disabled.';
    ?>
  </body>
</html>
