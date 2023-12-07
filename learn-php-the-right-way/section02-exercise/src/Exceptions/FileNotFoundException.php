<?php

  declare(strict_types=1);

  namespace Exercise02\Exceptions;

  use Exception;

  class FileNotFoundException extends Exception {
    protected $message = "File Not Found.";
  }
