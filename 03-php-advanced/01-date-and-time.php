<?php declare(strict_types=1) ?>
<?php date_default_timezone_set("Asia/Shanghai") ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>date and time</title>
  </head>
  <body>
    <h2>date(format,timestamp)</h2>
    <ol>
      <li>
        <?php
          echo "Today is " . date("Y/m/d") . "<br>";
          echo "Today is " . date("Y.m.d") . "<br>";
          echo "Today is " . date("Y-m-d") . "<br>";
          echo "Today is " . date("l");
        ?>
      </li>
      <li>&copy; 2010-<?php echo date("Y"); ?></li>
      <li><?php echo "The time is " . date("H:i:sa"); ?></li>
    </ol>

    <h2>mktime(hour, minute, second, month, day, year)</h2>
    <ol>
      <li>
        <?php
          $d = mktime(11, 14, 54, 8, 12, 2014);
          echo "Created date is " . date("Y-m-d h:i:sa", $d);
        ?>
      </li>
    </ol>

    <h2>strtotime(time, now)</h2>
    <ol>
      <li>
        <?php
          $d = strtotime("10:30pm April 15 2014");
          echo "Created date is " . date("Y-m-d h:i:sa", $d);
        ?>
      </li>
      <li>
        <?php
          $d = strtotime("tomorrow");
          echo date("Y-m-d h:i:sa", $d) . "<br>";

          $d = strtotime("next Saturday");
          echo date("Y-m-d h:i:sa", $d) . "<br>";

          $d = strtotime("+3 Months");
          echo date("Y-m-d h:i:sa", $d) . "<br>";
        ?>
      </li>
      <li>
        <?php
          $start = strtotime('Saturday');
          $end = strtotime('+6 weeks', $start);

          while ($start < $end) {
            echo date('M d', $start), '<br/>';
            $start = strtotime('+1 week', $start);
          }
        ?>
      </li>
      <li>
        <?php
          $day = 60 * 60 * 24 * 1;
          $d1 = strtotime('July 04');
          $d2 = ceil((time() - $d1) / $day);
          echo "There are " . $d2 . " days after 4th of July<br/>";
        ?>
      </li>
    </ol>
  </body>
</html>
