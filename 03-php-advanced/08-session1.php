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
      $_SESSION['favcolor'] = 'red';
      $_SESSION['favanimal'] = 'cat';
      echo 'Session variables are set.';

      // session_unset(); // remove all session variables
      session_destroy(); // destroy all data registered to to session
      // session_abort();
    ?>
  </body>
</html>
