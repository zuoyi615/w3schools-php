<?php

  namespace AttributedRouter\Exceptions\Container;

  use Exception;
  use Psr\Container\NotFoundExceptionInterface;

  class NotFoundException extends Exception implements NotFoundExceptionInterface { }
