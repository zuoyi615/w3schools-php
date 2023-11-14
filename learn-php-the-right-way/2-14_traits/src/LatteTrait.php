<?php

  namespace Traits;

  trait LatteTrait {
    protected string $milkType = 'whole-milk';

    public function makeLatte(): self {
      echo static::class.' is making latte with '.$this->getMilkType().PHP_EOL;
      return $this;
    }

    public function getMilkType(): string {
      if (property_exists($this, 'milkType')) {
        return $this->milkType;
      }

      return 'half-milk';
    }

    public function setMilkType(string $milkType): static {
      $this->milkType = $milkType;
      return $this;
    }

    // abstract public function getType(): string;

    public static function foo(): string {
      return 'Foo Bar'.PHP_EOL;
    }
  }
