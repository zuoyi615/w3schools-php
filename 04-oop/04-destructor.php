<?php

  class Fruit {
    function __construct(public $name, public $color) {
    }

    function __destruct() {
      echo "The fruit is {$this->name} and the color is {$this->color}.";
    }
  }

  $apple = new Fruit('Apple', 'red');
