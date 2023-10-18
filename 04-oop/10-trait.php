<?php

  trait message1 {
    public function msg1(): void {
      echo 'OOP is fun! ';
    }
  }

  trait message2 {
    public function msg2(): void {
      echo self::PI;
      echo '<br/>';
      echo "Hi, $this->name";
      echo '<br/>';
      echo 'OOP reduces code duplication!';
    }
  }

  class Welcome {
    use message1;
  }

  class Welcome2 {
    const PI = 3.14;

    function __construct(public $name) {
    }

    use message1, message2;
  }

  $welcome = new Welcome();
  $welcome->msg1();
  echo '<br/>';

  $welcome2 = new Welcome2('Jon');
  $welcome2->msg1();
  echo '<br/>';
  $welcome2->msg2();
  echo '<br/>';
