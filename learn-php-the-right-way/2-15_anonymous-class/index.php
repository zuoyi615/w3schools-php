<?php

  declare(strict_types=1);

  // extends, implementation, use trait
  $obj = new class (1, 2, 3) {
    public function __construct(public int $x, public int $y, public int $z) {}
  };

  var_dump($obj);
  var_dump(get_class($obj));
