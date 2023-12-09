<?php

  declare(strict_types=1);

  namespace PHPUnitTest\Exceptions;

  use Exception;

  class ViewNotFoundException extends Exception {
    protected $message = 'View Not Found';
  }
