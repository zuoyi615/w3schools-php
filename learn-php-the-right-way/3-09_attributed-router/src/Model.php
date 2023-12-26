<?php

  declare(strict_types=1);

  namespace AttributedRouter;

  abstract class Model {
    protected DB $db;

    public function __construct() {
      $this->db = App::db();
    }
  }
