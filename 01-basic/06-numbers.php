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
          var_dump(is_int(5985));
          echo '<br />';
          var_dump(is_int(59.85));
        ?>
      </li>
      <li>
        <?php
          var_dump(is_float(59.85));
        ?>
      </li>
      <li>
        <?php
          var_dump(is_infinite(1.9e411));
          echo '<br />';
          var_dump(is_finite(1.9e411));
        ?>
      </li>
      <li>
        <?php
          var_dump(is_nan(acos(8)));
        ?>
      </li>
      <li>
        <?php
          var_dump(is_numeric(5985));
          echo '<br />';
          var_dump(is_numeric('59.85'));
          echo '<br />';
          var_dump(is_numeric('59.85' + 100));
          echo '<br />';
          var_dump(is_numeric('Hello'));
          echo '<br />';
          var_dump(is_numeric(0xff0000));
          echo '<br />';
          var_dump(is_numeric('0xff0000'));
          echo '<br />';
          var_dump(is_numeric(0701));
          echo '<br />';
        ?>
      </li>
      <li>
        <?php
          $x = 2345.768;
          $int_cast = (int)$x;
          echo $int_cast;
          echo '<br />';

          $x = '2345.768';
          $int_cast = (int)$x;
          echo $int_cast;
          echo '<br />';

          $x = 'a2345.768';
          $int_cast = (int)$x;
          echo $int_cast; // this is 0, strange
          echo '<br />';
          var_dump(is_nan($int_cast));
          echo '<br />';

          $y = 0;
          echo (bool)$y;
          if (!is_nan($int_cast)) echo 'BAD';
        ?>
      </li>
    </ol>
  </body>
</html>
