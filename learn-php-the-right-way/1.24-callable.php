<?php

  function sum(int|float ...$numbers): int|float {
    return array_sum($numbers);
  }

  $x = 'sum';

  if (is_callable($x)) {
    echo $x(1, 2, 3, 4), PHP_EOL;
  } else {
    echo 'Not Callable', PHP_EOL;
  }

  function double(int $n): int {
    return $n * 2;
  }

  $arr = [1, 2, 3];
  $y = 5;
  $arr2 = array_map('double', $arr);
  $arr3 = array_map(fn($n) => $n * $n, $arr);
  $arr4 = array_map(fn($n) => $n * ++$y, $arr); // $y is not changed
  print_r($arr2);
  print_r($arr3);
  print_r($arr4);
  echo $y, PHP_EOL;

  $sum2 = function (callable $callback, int|float ...$numbers): int|float {
    return $callback(array_sum($numbers));
  };

  echo $sum2(fn($n) => $n * 2, 1, 2, 3, 4), PHP_EOL;
