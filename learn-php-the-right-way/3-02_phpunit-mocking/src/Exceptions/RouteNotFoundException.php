<?php

  declare(strict_types=1);

  namespace PHPUnitMocking\Exceptions;

  use Exception;

  class RouteNotFoundException extends Exception {
    protected $message = '404 Not Found';
  }
