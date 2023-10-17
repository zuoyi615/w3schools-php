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
    <h2>filter_list()</h2>
    <table>
      <tr>
        <td>Filter Name</td>
        <td>Filter ID</td>
      </tr>
      <?php
        foreach (filter_list() as $id => $filter) {
          echo "<tr><td>$filter</td><td>" . filter_id($filter) . "</td></tr>";
        }
      ?>
    </table>
    <h2>filter_var()</h2>
    <p>
      <?php
        $str = '<h1>Hello World!</h1>';
        $str = filter_var($str, FILTER_SANITIZE_STRING);
        // $str = htmlspecialchars($str);
        // $str = filter_var($str, FILTER_UNSAFE_RAW);
        echo $str;
      ?>
    </p>
  </body>
</html>
