<?php declare(strict_types=1) ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>filters advanced</title>
  </head>
  <body>
    <h2>Validate an Integer Within a Range</h2>
    <p>
      <?php
        $int = 332;
        $range = ['options' => ['min_range' => 1, 'max_range' => 200]];
        if (filter_var($int, FILTER_VALIDATE_INT, $range) !== false) {
          echo("$int is within the legal range");
        } else {
          echo("$int is not within the legal range");
        }
      ?>
    </p>

    <h2>Validate IPv6 Address</h2>
    <p>
      <?php
        $ip = "2001:0db8:85a3:08d3:1319:8a2e:0370:7334";
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
          echo("$ip is a valid IPv6 address");
        } else {
          echo("$ip is a not valid IPv6 address");
        }
      ?>
    </p>
    <h2>Validate URL - Must Contain QueryString</h2>
    <p>
      <?php
        $url = "https://www.w3schools.com";
        if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED) !== false) {
          echo("$url is a valid URL with a query string");
        } else {
          echo("$url is not a valid URL with a query string");
        }
      ?>
    </p>

    <h2>Remove Characters With ASCII Value > 127</h2>
    <p>
      <?php
        $str = "<h1>Hello WorldÆØÅ!</h1>";
        // $newstr = filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); // Deprecated
        $newstr = filter_var($str, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_HIGH);
        echo $newstr;
      ?>
    </p>


    <?php return; ?>
    <h2>this After 'return;' will not render </h2>
    <h2>this After 'return;' will not render </h2>
    <h2>this After 'return;' will not render </h2>
    <h2>this After 'return;' will not render </h2>
    <h2>this After 'return;' will not render </h2>
  </body>
</html>
