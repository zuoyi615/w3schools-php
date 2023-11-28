<?php

  declare(strict_types=1);

  namespace RequestHeaders\Exceptions;

  use Exception;

  class ViewNotFoundException extends Exception {
    protected $message = 'View Not Found';
  }
