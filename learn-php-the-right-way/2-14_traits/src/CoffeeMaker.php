<?php

  declare(strict_types=1);

  namespace Traits;

  class CoffeeMaker {
    public function makeCoffee(): static {
      echo static::class.' is making coffee'.PHP_EOL;
      return $this;
    }
  }
