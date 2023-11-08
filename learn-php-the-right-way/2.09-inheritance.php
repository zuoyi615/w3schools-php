<?php

  declare(strict_types=1);

  namespace Inheritance;

  class Toaster {
    public array $slices = [];
    public int   $size   = 2;

    public function addSlice(string $slice): self {
      if (count($this->slices) < $this->size) {
        $this->slices[] = $slice;
      }
      return $this;
    }

    public function toast(): void {
      foreach ($this->slices as $i => $slice) {
        echo ($i + 1).': Toasting '.$slice.PHP_EOL;
      }
    }
  }

  $toaster = new Toaster();
  $toaster
    ->addSlice('bread')
    ->addSlice('bread')
    ->addSlice('bread')
    ->addSlice('bread');
  $toaster->toast();
