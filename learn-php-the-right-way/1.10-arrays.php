<?php
  $languages = ['PHP', 'Java', 'Python'];
  print_r($languages);
  echo count($languages);

  $languages[] = 'JavaScript';
  array_push($languages, 'Go', 'Rust', ...$languages);
  echo PHP_EOL;
  print_r($languages);
  echo count($languages);

  $newLanguages = [
    'php' => '8.2.11',
    'python' => '3.11',
    'JavaScript' => 'ES2015'
  ];
  echo PHP_EOL;
  print_r($newLanguages);
  echo $newLanguages['php'];
  $newLanguages['Lua'] = '1.1';
  print_r($newLanguages);

  $array = [
    true => 'a',  // 1->'a'
    '1' => 'b',
    1 => 'c',
    1.8 => 'd',
    null => 'e',  // equals to ''
    false => 'f', // 0=>'false
  ];
  echo PHP_EOL;
  print_r($array);
  echo $array[''];

  $array = ['a', 'b', 50 => 'c', 'd', 'e'];
  echo PHP_EOL;
  print_r($array);

  $array = ['a', 'b', 'test' => 'c', 'd', 'e'];
  echo PHP_EOL;
  print_r($array);

  echo array_pop($array);
  print_r($array);

  echo PHP_EOL;
  $array = ['a', 'b', 'test' => 'c', 'd', 'e'];
  unset($array[2]);
  print_r($array);
  echo count($array);
  echo PHP_EOL;
  // echo $array[2]; // Throw Warning
  echo $array[] = 'f';

  $x = 5;
  var_dump((array)$x);
  echo PHP_EOL;

  $x = null;
  var_dump((array)$x);
  echo PHP_EOL;

  $arr = ['a' => 1, 'b' => null];
  // var_dump(array_key_exists('a', $arr));
  var_dump(array_key_exists('c', $arr));
  echo PHP_EOL;

  // var_dump(isset($arr['a']));
  var_dump(isset($arr['b']));
  echo PHP_EOL;
