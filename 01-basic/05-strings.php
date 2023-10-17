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
          // strlen()
          echo "strlen('Hello World!'): " . strlen('Hello World!');
        ?>
      </li>
      <li>
        <?php
          // str_word_count()
          echo "str_word_count('Hello World!'): " . str_word_count('Hello World!');
        ?>
      </li>
      <li>
        <?php
          // strrev()
          echo "strrev('Hello World!'): " . strrev('Hello World!');
        ?>
      </li>
      <li>
        <?php
          // strpos()
          echo "strpos('Hello World!', 'World'): " . strpos('Hello World!', 'World');
        ?>
      </li>
      <li>
        <?php
          // str_replace()
          echo "str_replace('World', 'Gavin', 'Hello World!'): " . str_replace('World', 'Gavin', 'Hello World!');
        ?>
      </li>
    </ul>
  </body>
</html>
