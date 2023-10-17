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
    <ol>
      <li>
        <?php
          $str = 'Hello World!';
          // $pattern = '/world/i';
          $pattern = '/world/i';
          echo preg_match($pattern, $str); // 1
          echo '<br/>';
          echo preg_match('/test/i', $str); // 0
        ?>
      </li>
      <li>
        <?php
          $str = "The rain in SPAIN falls mainly on the plains.";
          $pattern = '/ain/i';
          echo preg_match_all($pattern, $str); // 4
        ?>
      </li>
      <li>
        <?php
          $str = 'Hello World!';
          $pattern = '/world/i';
          echo preg_replace($pattern, 'Gavin', $str);
        ?>
      </li>
      <li>
        <?php
          $str = "Apples and bananas.";
          $pattern = '/ba(na){2}/i';
          echo preg_match($pattern, $str);
        ?>
      </li>
    </ol>
  </body>
</html>
