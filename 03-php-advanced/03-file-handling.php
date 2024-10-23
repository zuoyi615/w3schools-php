<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>file handling</title>
  </head>
  <body>
    <h2>readfile()</h2>
    <ul>
      <li><?php echo readfile('webdictionary.txt') ?></li>
    </ul>

    <h2>fopen(), fread(), fclose()</h2>
    <ol>
      <?php
        $filename = 'webdictionary.html';
        $file = fopen($filename, 'r') or die('unable to open file.');
        echo fread($file, filesize($filename));
        fclose($file);
      ?>
    </ol>

    <h2>fgets()</h2>
    <ol>
      <?php
        $filename = 'webdictionary.html';
        $file = fopen($filename, 'r') or die('unable to open file.');
        echo fgets($file);
        fclose($file);
      ?>
    </ol>

    <h2>feof()</h2>
    <ol>
      <?php
        $filename = 'webdictionary.html';
        $file = fopen($filename, 'r') or die('unable to open file.');
        while (!feof($file)) {
          echo fgets($file);
        }
        fclose($file);
      ?>
    </ol>

    <h2>fgetc()</h2>
    <div>
      <?php
        $filename = 'webdictionary.html';
        $file = fopen($filename, 'r') or die('unable to open file.');
        while (!feof($file)) {
          echo htmlspecialchars(fgetc($file));
        }
        fclose($file);
        echo '<br />', filesize($filename);
      ?>
    </div>
  </body>
</html>
