<?php
  $x = 123;
  var_dump($x);
  unset($x);

  // var_dump($x);

  $x = null;
  var_dump((string) $x);
  echo '<br />';
  var_dump((int) $x);
  echo '<br />';
  var_dump((float) $x);
  echo '<br />';
  var_dump((bool) $x);
  echo '<br />';
  var_dump((array) $x);
  echo '<br />';
