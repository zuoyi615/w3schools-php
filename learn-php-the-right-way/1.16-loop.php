<?php
  $i = 0;
  while ($i < 10) echo PHP_EOL, $i++;

  $i = 0;
  while ($i <= 15): // used for generating html
    echo PHP_EOL, $i++;
  endwhile;

  $languages = ['PHP', 'Java', 'C++', 'Go', 'Rust'];
  foreach ($languages as $key => &$language) {
    echo PHP_EOL;
    echo "$key: $language";
  }

  echo PHP_EOL;
  echo "$key: $language";

  unset($key, $language);
  $key = 5;
  $language = 'JavaScript';

  echo PHP_EOL;
  print_r($languages);
  echo "$key: $language";
  unset($key, $language);

  $user = [
    'name' => 'Gavin',
    'email' => 'gavin.io@gmail.com',
    'skills' => ['PHP', 'React', 'Nodejs']
  ];

  echo PHP_EOL;
  foreach ($user as $property => $value) {
    if (is_array($value)) $value = implode(',', $value);
    echo "$property: $value";
    echo PHP_EOL;
  }

  // for:
  // endfor;

  // foreach ():
  // endforeach;
