<?php

  namespace _SERVER\Exceptions;

  use Exception;

  class RouteNotFoundException extends Exception {
    protected $message = '404 Not Found';
  }
