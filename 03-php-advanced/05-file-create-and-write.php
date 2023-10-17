<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>create and write</title>
  </head>
  <body>
    <h2>Create and write</h2>
    <?php
      $file = fopen('test.txt', 'w');

      $filename = 'test1.txt';
      $file = fopen($filename, 'w') or die('Unable to open file!');
      $txt = "John Doe\n";
      fwrite($file, $txt);
      $txt = "Jane Doe\n";
      fwrite($file, $txt);
      fclose($file);
      // $file = fopen($filename, 'r') or die('Unable to open file!');
      // echo fread($file, filesize($filename));
      // fclose($file);
    ?>
    <?php
      $file = fopen('test.txt', 'w');

      $filename = 'test1.txt';
      $file = fopen($filename, 'a') or die('Unable to open file!');
      $txt = "Donald Duck\n";
      fwrite($file, $txt);
      $txt = "Goofy Goof\n";
      fwrite($file, $txt);
      fclose($file);
      // $file = fopen($filename, 'r') or die('Unable to open file!');
      // echo fread($file, filesize($filename));
      // fclose($file);
    ?>
  </body>
</html>
