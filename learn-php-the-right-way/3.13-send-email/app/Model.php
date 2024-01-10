<?php

  declare(strict_types=1);

  namespace SendEmail;

  use PDOStatement;

  abstract class Model {
    protected DB $db;

    public function __construct() {
      $this->db = SendEmail::db();
    }

    public function fetchLazy(PDOStatement $stmt): \Generator {
      foreach ($stmt as $record) {
        yield $record;
      }
    }
  }
