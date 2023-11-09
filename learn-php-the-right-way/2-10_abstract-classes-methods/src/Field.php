<?php

  declare(strict_types=1);
  namespace Abstraction;


  /**
   * abstract class do not care about implementation details
   */
  abstract class Field {
    public function __construct(protected string $name) {}

    abstract public function render(): string;
  }
