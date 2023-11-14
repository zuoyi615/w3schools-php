<?php

  declare(strict_types=1);

  use StaticBinding\{ClassA, ClassB};

  require_once 'vendor/autoload.php';

  // $classA = new ClassA();
  // $classB = new ClassB();
  // echo $classA->getName(), PHP_EOL;
  // echo $classB->getName(), PHP_EOL;

  // echo ClassA::getName(), PHP_EOL;
  // echo ClassB::getName(), PHP_EOL;

  var_dump(ClassA::make()); // ClassA
  var_dump(ClassB::make()); // ClassB
