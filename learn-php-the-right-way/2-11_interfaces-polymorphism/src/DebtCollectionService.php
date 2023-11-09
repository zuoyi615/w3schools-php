<?php

  declare(strict_types=1);

  namespace Debt;

  class DebtCollectionService {
    public function collectDebt(DebtCollector $collector): void {
      // var_dump($collector instanceof DebtCollector); // true
      // var_dump($collector instanceof CollectionAgency); // false
      $ownedAmount     = mt_rand(100, 1000);
      $collectedAmount = $collector->collect($ownedAmount);
      echo "Collected $$collectedAmount out of $$ownedAmount", PHP_EOL;
    }
  }
