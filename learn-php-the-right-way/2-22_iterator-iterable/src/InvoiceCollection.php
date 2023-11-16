<?php

  declare(strict_types=1);

  namespace IteratorIterable;

  use Iterator;
  use IteratorAggregate;
  use Traversable;
  use ArrayIterator;

  class InvoiceCollection0 implements Iterator {
    public function __construct(public array $invoices) {}

    public function current(): Invoice {
      echo __METHOD__, PHP_EOL;
      return current($this->invoices);
    }

    public function next(): void {
      echo __METHOD__, PHP_EOL;
      next($this->invoices);
    }

    public function key(): int {
      echo __METHOD__, PHP_EOL;
      return key($this->invoices);
    }

    public function valid(): bool {
      echo __METHOD__, PHP_EOL;
      $valid = current($this->invoices) !== false;
      var_dump($valid);
      return $valid;
    }

    public function rewind(): void {
      echo __METHOD__, PHP_EOL;
      reset($this->invoices);
    }
  }

  class InvoiceCollection1 implements Iterator {
    private int $index = 0;

    public function __construct(public array $invoices) {}

    public function current(): Invoice {
      echo __METHOD__, PHP_EOL;
      return $this->invoices[$this->index];
    }

    public function next(): void {
      echo __METHOD__, PHP_EOL;
      ++$this->index;
    }

    public function key(): int {
      echo __METHOD__, PHP_EOL;
      return $this->index;
    }

    public function valid(): bool {
      echo __METHOD__, PHP_EOL;
      return isset($this->invoices[$this->index]);
    }

    public function rewind(): void {
      echo __METHOD__, PHP_EOL;
      $this->index = 0;
    }
  }

  class InvoiceCollection extends Collection { }
