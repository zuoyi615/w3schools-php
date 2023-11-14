<?php

  declare(strict_types=1);

  namespace Traits;

  class CappuccinoMaker {
    use CappuccinoTrait {
      CappuccinoTrait::makeCappuccino as public;
    }
  }
