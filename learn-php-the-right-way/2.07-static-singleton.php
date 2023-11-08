<?php

  declare(strict_types=1);

  namespace Singleton;

  class DB {
    private static ?DB $instance = null;

    public static function getInstance(array $config): ?DB {
      if (self::$instance === null) {
        self::$instance = new DB($config);
      }
      return self::$instance;
    }

    private function __construct(public array $config) {}
  }

  $db = DB::getInstance([]);
  $db1 = DB::getInstance([]);
  var_dump($db===$db1);
