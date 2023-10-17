<?php
  declare(strict_types=1);
  session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>session</title>
  </head>
  <body>
    <?php
      echo "Favorite color is " . $_SESSION["favcolor"] . ".<br />";
      echo "Favorite animal is " . $_SESSION["favanimal"] . ".<br />";
      print_r($_SESSION);
      echo '<br />';
      $_SESSION['favcolor'] = 'green';
      print_r($_SESSION);
    ?>
  </body>
</html>
