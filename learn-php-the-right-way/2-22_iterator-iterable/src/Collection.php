<?php

  declare(strict_types=1);

  namespace IteratorIterable;

  use IteratorAggregate;
  use ArrayIterator;
  use Traversable;

  class Collection implements IteratorAggregate {
    public function __construct(private readonly array $items) {}

    public function getIterator(): Traversable {
      return new ArrayIterator($this->items);
    }
  }
