<?php declare(strict_types=1) ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>callback</title>
  </head>
  <body>
    <h2>callback</h2>
    <p>
      <?php
        function len($str): int {
          return strlen($str);
        }

        $strings = ["apple", "orange", "banana", "coconut"];
        $lengths = array_map('len', $strings);
        $lengths = array_map(
          function ($s) {
            return strlen($s);
          },
          $strings,
        );
        print_r($lengths);
      ?>
    </p>

    <h2>Callbacks in User Defined Functions</h2>
    <p>
      <?php
        function exclaim($str): string {
          return "$str!";
        }

        function ask($str): string {
          return "$str?";
        }

        function print_formatted(string $str, $format): void {
          echo $format($str) . '<br/>';
        }

        print_formatted("Hello world", "exclaim");
        print_formatted("Hello world", "ask");
      ?>
    </p>
  </body>
</html>
