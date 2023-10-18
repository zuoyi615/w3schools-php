<?php

  class Pi {
    static float $value = 3.14159;

    function getValue(): float {
      return self::$value;
    }
  }

  echo Pi::$value;
  echo '<br/>';

  $pi = new Pi();
  echo $pi->getValue();
  echo '<br/>';

  class X extends Pi {
  }

  echo X::$value;
  echo '<br/>';

  $x = new X();
  echo $x->getValue();
