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
        // $str = filter_var($str, FILTER_SANITIZE_STRING); // deprecated, result: Hello World!
        $str = htmlspecialchars($str); // recommended
        // $str = filter_var($str, FILTER_UNSAFE_RAW);
        echo $str;
      ?>
    </p>

    <h2>FILTER_VALIDATE_INT</h2>
    <p>
      <?php
        $int = 0;
        if (filter_var($int, FILTER_VALIDATE_INT) !== false) {
          echo 'Integer is valid.';
        } else {
          echo 'Integer is not valid.';
        }
      ?>
    </p>

    <h2>Validate an IP Address</h2>
    <p>
      <?php
        $ip = '127.0.0.1';
        if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
          echo "$ip is a valid IP address.";
        } else {
          echo "$ip is not a valid IP address.";
        }
      ?>
    </p>

    <h2>Sanitize and Validate an Email Address</h2>
    <p>
      <?php
        $email = '<></>john.doe@example.com ';
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          echo "$email is a valid email address.";
        } else {
          echo "$email is not a valid email address.";
        }
      ?>
    </p>

    <h2>Sanitize and Validate a URL</h2>
    <p>
      <?php
        $url = "https://www.w3schools.com";
        $url = filter_var($url, FILTER_SANITIZE_URL);
        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
          echo("$url is a valid URL.");
        } else {
          echo("$url is not a valid URL.");
        }
      ?>
    </p>
  </body>
</html>
