<?php

  declare(strict_types=1);

  use Traits\{AllInOneCoffeeMaker, CoffeeMaker, LatteMaker, CappuccinoMaker};

  require_once 'vendor/autoload.php';

  $coffeeMaker = new CoffeeMaker();
  $coffeeMaker->makeCoffee();

  $latteMaker = new LatteMaker();
  $latteMaker->makeLatte();

  $cappuccinoMaker = new CappuccinoMaker();
  $cappuccinoMaker->makeCappuccino();

  $allInOneCoffeeMaker = new AllInOneCoffeeMaker();
  $allInOneCoffeeMaker
    ->makeCoffee()
    ->makeLatte()
    ->makeOriginLatte()
    ->makeCappuccino();
  echo LatteMaker::foo();
