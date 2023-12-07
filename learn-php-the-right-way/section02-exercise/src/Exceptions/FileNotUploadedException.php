<?php

  declare(strict_types=1);

  namespace Exercise02\Exceptions;

  use Exception;

  class FileNotUploadedException extends Exception {
    protected $message = "File 'file' Not Uploaded.";
  }
