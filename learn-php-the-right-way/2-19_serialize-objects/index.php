<?php

  declare(strict_types=1);

  use SerializeObjects\Invoice;

  require_once 'vendor/autoload.php';

  $invoice = new Invoice(25, 'Invoice 01', '10001100');

  echo serialize(true), PHP_EOL;
  echo serialize(1), PHP_EOL;
  echo serialize(1.5), PHP_EOL;
  echo serialize('Hello World'), PHP_EOL;
  echo serialize([1, 2, 3]), PHP_EOL;
  echo serialize(['name' => 'Jon', 'age' => 16, 'gender' => 'male']), PHP_EOL;
  $str = 'a:3:{s:4:"name";s:3:"Jon";s:3:"age";i:16;s:6:"gender";s:4:"male";}';
  var_dump(unserialize($str));
  echo PHP_EOL;

  $s = serialize($invoice);
  echo $s, PHP_EOL;
  // $s = 'O:24:"SerializeObjects\Invoice":1:{s:28:" SerializeObjects\Invoice id";s:21:"invoice_655435c36863f";}';
  // var_dump(serialize($s));
  // var_dump(unserialize(serialize($invoice))); // deep copy and deep clone an object
  // var_dump($invoice);
  var_dump(unserialize($s));

  echo PHP_EOL;
  // var_dump(serialize(false));
