<?php

  declare(strict_types=1);

  namespace Traits;

  class AllInOneCoffeeMaker extends CoffeeMaker {
    use CappuccinoTrait {
      CappuccinoTrait::makeLatte insteadof LatteTrait;
      CappuccinoTrait::makeCappuccino as public; // not recommended; do not change visibility
    }
    use LatteTrait {
      LatteTrait::makeLatte as makeOriginLatte;
    }
  }
