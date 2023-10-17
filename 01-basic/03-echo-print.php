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
          echo "<h2>PHP is Fun.</h2>";
          echo("Hello PHP. <br />");
          echo "I'm about to learn PHP. <br />";
          echo "<strong>This", "string", "was", "made", "with multiple parameters.</strong>"
        ?>
      </li>
      <li>
        <?php
          $txt1 = 'Learn PHP';
          $txt2 = 'W3Schools.com';
          $x = 3;
          $y = 4;

          echo "<h2> $txt1 </h2>";
          echo "<h2>", $txt1, "</h2>";
          echo "Study PHP at $txt2 <br/>";
          echo($x + $y);
        ?>
      </li>
      <li>
        <?php
          // print
          print "<h2>PHP is Fun.</h2>";
          print("Hello PHP. <br />");
          print "I'm about to learn PHP. <br />";
        ?>
      </li>
      <li>
        <?php
          print "<h2>" . $txt1 . "</h2>";
          print "Study PHP at " . $txt2 . "<br/>";
          print($x + $y);
        ?>
      </li>
    </ul>
  </body>
</html>
