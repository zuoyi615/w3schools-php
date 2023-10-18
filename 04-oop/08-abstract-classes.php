<?php

  abstract class Car {
    function __construct(public string $name) {
    }

    abstract function intro(): string;
  }

  class Audi extends Car {
    function intro(): string {
      return "Choose German quality! I'm an $this->name!";
    }

  }

  class Volvo extends Car {
    public function intro(): string {
      return "Proud to be Swedish! I'm a $this->name!";
    }
  }

  class Citroen extends Car {
    public function intro(): string {
      return "French extravagance! I'm a $this->name!";
    }
  }

  $audi = new audi("Audi");
  echo $audi->intro();
  echo "<br>";

  $volvo = new volvo("Volvo");
  echo $volvo->intro();
  echo "<br>";

  $citroen = new citroen("Citroen");
  echo $citroen->intro();


  abstract class ParentClass {
    abstract protected function prefixName(string $name): string;
  }

  class ChildClass extends ParentClass {
    function prefixName(string $name, $separator = '.', $greet = 'Dear'): string {
      if ($name == "John Doe") $prefix = "Mr";
      elseif ($name == "Jane Doe") $prefix = "Mrs";
      else $prefix = "";
      return "{$greet} {$prefix}{$separator} {$name}";
    }
  }

  $class = new ChildClass;
  echo "<br>";
  echo $class->prefixName("John Doe");
  echo "<br>";
  echo $class->prefixName("Jane Doe");
