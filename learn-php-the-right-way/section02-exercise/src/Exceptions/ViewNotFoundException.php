<?php

  declare(strict_types=1);

  namespace Exercise02\Exceptions;

  use Exception;

  class ViewNotFoundException extends Exception {
    protected $message = 'View Not Found';
  }
