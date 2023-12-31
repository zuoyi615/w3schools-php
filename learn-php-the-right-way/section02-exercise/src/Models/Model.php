<?php

  declare(strict_types=1);

  namespace Exercise02\Models;

  use Exercise02\App;
  use Exercise02\DB;

  class Model {
    protected DB $db;

    public function __construct() {
      $this->db = App::db();
    }
  }
