<?php
  // date_default_timezone_set('Asia/Shanghai');
  // date_default_timezone_set('Etc/GMT-8');
  // date_default_timezone_set('UTC');

  $now = time();
  echo $now, PHP_EOL;
  echo $now + 5 * 24 * 60 * 60, PHP_EOL;
  echo $now + 24 * 60 * 60, PHP_EOL;
  echo date('Y/m/d H:i:s'), PHP_EOL;
  echo date('Y/m/d H:i:s', $now + 5 * 24 * 60 * 60), PHP_EOL;
  echo date('Y/m/d H:i:s', $now - 24 * 60 * 60), PHP_EOL;
  echo date_default_timezone_get(), PHP_EOL;

  echo PHP_EOL;
  $date = mktime(0, 0, 0, 4, 10);
  echo $date, PHP_EOL;
  echo date('Y/m/d H:i:s', $date), PHP_EOL;

  echo PHP_EOL;
  $date = strtotime('yesterday');
  echo $date, PHP_EOL;
  echo date('Y/m/d H:i:s', $date), PHP_EOL;

  echo PHP_EOL;
  $date = strtotime('tomorrow');
  echo $date, PHP_EOL;
  echo date('Y/m/d H:i:s', $date), PHP_EOL;

  echo PHP_EOL;
  $date = strtotime('1993/01/01 13:00:00');
  echo $date, PHP_EOL;
  echo date('Y/m/d H:i:s', $date), PHP_EOL;

  echo PHP_EOL;
  $date = strtotime('second friday of January');
  echo $date, PHP_EOL;
  $date = date('Y/m/d H:i:s', $date);
  echo $date, PHP_EOL;

  print_r(date_parse($date));

