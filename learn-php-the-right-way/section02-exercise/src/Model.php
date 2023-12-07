<?php

  declare(strict_types=1);

  namespace Exercise02;

  class Model {
    protected DB $db;

    public function __construct() {
      $this->db = App::db();
    }
  }
