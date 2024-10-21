<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>math</title>
    <style>
    code {
      background: gainsboro;
    }
    </style>
  </head>
  <body>
    <ul>
      <li>
        <?php
          echo '<code>pi()</code> : ', pi();
        ?>
      </li>
      <li>
        <?php
          echo '<code>min(0, 150, 30, 20, -8, -200)</code> : ', min(0, 150, 30, 20, -8, -200);
          echo('<br/>');
          echo '<code>max(0, 150, 30, 20, -8, -200)</code> : ', max(0, 150, 30, 20, -8, -200);
        ?>
      </li>
      <li>
        <?php
          echo '<code>abs(-1)</code> : ', abs(-1);
        ?>
      </li>
      <li>
        <?php
          echo '<code>sqrt(81)</code> : ', sqrt(81);
        ?>
      </li>
      <li>
        <?php
          echo '<code>round(0.60)</code> : ', round(0.60);
          echo('<br/>');
          echo '<code>round(0.49)</code> : ', round(0.49);
        ?>
      </li>
      <li>
        <?php
          echo '<code>rand()</code> : ', rand();
          echo('<br/>');
          echo '<code>rand(10, 100)</code> : ', rand(10, 100);
          echo('<br/>');
          echo '<code>rand(0, 100000) / 100000</code> : ', rand(0, 100000) / 100000;
          echo('<br/>');
          echo '<code>rand(0, 1)</code> : ', rand(0, 1);
        ?>
      </li>
    </ul>
  </body>
</html>
