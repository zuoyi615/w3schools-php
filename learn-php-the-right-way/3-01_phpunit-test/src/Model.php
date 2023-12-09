<?php

  declare(strict_types=1);

  namespace PHPUnitTest;

  abstract class Model {
    protected DB $db;

    public function __construct() {
      $this->db = App::db();
    }
  }
