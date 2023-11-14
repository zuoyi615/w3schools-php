<?php

  namespace Traits;

  trait CappuccinoTrait {
    use LatteTrait;

    private function makeCappuccino(): static {
      echo static::class.' is making cappuccino'.PHP_EOL;
      return $this;
    }

    public function makeLatte(): static {
      echo static::class.' is making latte (Cappuccino Trait)'.PHP_EOL;
      return $this;
    }
  }
