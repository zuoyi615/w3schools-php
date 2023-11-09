<?php

  declare(strict_types=1);

  use Debt\{CollectionAgency, DebtCollectionService, Rocky};

  //use Interface\DebtCollectionService;

  require 'vendor/autoload.php';

  // $collector = new CollectionAgency();
  // echo $collector->collect(100), PHP_EOL;

  $collector = new CollectionAgency();
  $rocky     = new Rocky();
  $service   = new DebtCollectionService();
  $service->collectDebt($collector);
  echo '<br />';
  $service->collectDebt($rocky);
