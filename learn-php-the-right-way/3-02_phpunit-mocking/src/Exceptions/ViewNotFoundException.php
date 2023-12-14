<?php

  declare(strict_types=1);

  namespace PHPUnitMocking\Exceptions;

  use Exception;

  class ViewNotFoundException extends Exception {
    protected $message = 'View Not Found';
  }
