<?php

  declare(strict_types=1);

  namespace AttributedRouter;

  use PDO;
  use PDOException;

  /**
   * @mixin PDO
   */
  class DB {
    private PDO $pdo;

    public function __construct(private readonly array $config) {
      $defaultOptions = [
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ];

      $host    = $config['host'];
      $dbname  = $config['dbname'];
      $user    = $config['user'];
      $pass    = $config['pass'];
      $driver  = $config['driver'];
      $options = $config['options'] ?? $defaultOptions;

      try {
        $this->pdo = new PDO("$driver:host=$host;dbname=$dbname", $user, $pass, $options);
      } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
      }
    }

    public function __call(string $name, array $arguments) {
      return call_user_func_array([$this->pdo, $name], $arguments);
    }
  }
