<?php

  declare(strict_types=1);

  namespace PDOTransactions\Exceptions;

  use Exception;

  class RouteNotFoundException extends Exception {
    protected $message = '404 Not Found';
  }
