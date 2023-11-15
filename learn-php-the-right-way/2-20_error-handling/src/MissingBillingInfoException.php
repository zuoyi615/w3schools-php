<?php

  declare(strict_types=1);

  namespace ErrorHandling;

  use Exception;

  class MissingBillingInfoException extends Exception {
    protected $message = 'Missing billing information';
  }
