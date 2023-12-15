<?php

  declare(strict_types=1);

  namespace DIContainer\Exceptions;

  use Exception;

  class RouteNotFoundException extends Exception {
    protected $message = '404 Not Found';
  }
