<?php

  declare(strict_types=1);

  namespace MVCModels\Models;

  use MVCModels\{App, DB};

  abstract class Model {
    protected DB $db;

    public function __construct() {
      $this->db = App::db();
    }
  }
