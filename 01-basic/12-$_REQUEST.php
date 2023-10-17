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

    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
      <label>
        Name: <input type="text" name="username" />
      </label>
      <input type="submit" />
    </form>


    <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_REQUEST['username'];
        if (empty($username)) {
          echo '<p style="color: red;">Name is empty</p>';
        } else {
          echo "<h3>$username</h3>";
        }
      }
    ?>
  </body>
</html>
