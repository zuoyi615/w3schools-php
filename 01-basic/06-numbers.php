<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
      code {
        background: gainsboro;
      }
    </style>
  </head>
  <body>
    <ol>
      <li>
        <?php
          echo '<code>is_int(5985)</code>';
          var_dump(is_int(5985));
          echo '<code>is_int(59.85)</code>';
          var_dump(is_int(59.85));
        ?>
      </li>
      <li>
        <?php
          echo '<code>is_float(59.85)</code>';
          var_dump(is_float(59.85));
        ?>
      </li>
      <li>
        <?php
          echo '<code>is_infinite(1.9e411)</code>';
          var_dump(is_infinite(1.9e411));
          echo '<code>is_finite(1.9e411)</code>';
          var_dump(is_finite(1.9e411));
        ?>
      </li>
      <li>
        <?php
          echo '<code>is_nan(acos(8))</code>';
          var_dump(is_nan(acos(8)));
          echo '<code>is_nan(acos(0.5))</code>';
          var_dump(is_nan(acos(0.5)));
        ?>
      </li>
      <li>
        <?php
          echo '<code>is_numeric(5985)</code>';
          var_dump(is_numeric(5985));
          echo '<code>is_numeric(59.85)</code>';
          var_dump(is_numeric('59.85'));
          echo '<code>is_numeric(\'59.85\'+100)</code>';
          var_dump(is_numeric('59.85' + 100));
          echo '<code>is_numeric(\'Hello\')</code>';
          var_dump(is_numeric('Hello'));
          echo '<code>is_numeric(0xff0000)</code>';
          var_dump(is_numeric(0xff0000));
          echo '<code>is_numeric(\'0xff0000\')</code>';
          var_dump(is_numeric('0xff0000'));
          echo '<code>is_numeric(0701)</code>';
          var_dump(is_numeric(0701));
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
          var_dump(is_numeric($x));
          var_dump(is_nan($int_cast));

          $y = 0;
          echo (bool)$y;
          echo '<code>(bool)$y</code>';
          var_dump((bool)$y);
          if (!is_nan($int_cast)) echo 'BAD';
        ?>
      </li>
    </ol>
  </body>
</html>
