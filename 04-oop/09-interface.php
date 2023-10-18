<?php

  interface Animal {
    public function makeSound(): void;
  }

  class Cat implements Animal {
    public function makeSound(): void {
      echo " Meow ";
    }
  }

  class Dog implements Animal {
    public function makeSound(): void {
      echo " Bark ";
    }
  }

  class Mouse implements Animal {
    public function makeSound(): void {
      echo " Squeak ";
    }
  }

  $cat = new Cat();
  $dog = new Dog();
  $mouse = new Mouse();
  $animals = array($cat, $dog, $mouse);

  foreach ($animals as $animal) {
    $animal->makeSound();
  }
