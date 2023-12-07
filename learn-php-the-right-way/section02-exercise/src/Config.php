<?php

  declare(strict_types=1);

  namespace Exercise02;

  /**
   * @property-read ?array $db
   */
  class Config {
    private array $config = [];

    public function __construct(array $env) {
      $this->config = [
        'db' => [
          'host'   => $env['DB_HOST'],
          'user'   => $env['DB_USER'],
          'pass'   => $env['DB_PASS'],
          'dbname' => $env['DB_DATABASE'],
          'driver' => $env['DB_DRIVER'] ?? 'mysql',
        ]
      ];
    }

    public function __get(string $name) {
      return $this->config[$name] ?? null;
    }
  }
