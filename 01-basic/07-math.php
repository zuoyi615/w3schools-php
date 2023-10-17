<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>math</title>
  </head>
  <body>
    <ul>
      <li>
        <?php
          echo pi();
        ?>
      </li>
      <li>
        <?php
          echo(min(0, 150, 30, 20, -8, -200));
          echo('<br/>');
          echo(max(0, 150, 30, 20, -8, -200));
        ?>
      </li>
      <li>
        <?php
          echo abs(-1);
        ?>
      </li>
      <li>
        <?php
          echo sqrt(81);
        ?>
      </li>
      <li>
        <?php
          echo round(0.60);
          echo('<br/>');
          echo round(0.49);
        ?>
      </li>
      <li>
        <?php
          echo rand();
          echo('<br/>');
          echo rand(10, 100);
          echo('<br/>');
          echo rand(0, 100000) / 100000;
          echo('<br/>');
          echo rand(0, 1);
          echo('<br/>');
        ?>
      </li>
    </ul>
  </body>
</html>
