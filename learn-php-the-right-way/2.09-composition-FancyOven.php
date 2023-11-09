<?php

  declare(strict_types=1);

  namespace Inheritance;

  require_once './2.09-inheritance-toaster-pro.php';

  /**
   * Inheritance vs Composition
   */
  readonly class FancyOven {
    public function __construct(private ToasterPro $toaster) {}

    public function fry() {
      // fry something
    }

    public function toast(): void {
      $this->toaster->toast();
    }

    public function toastBagel(): void {
      $this->toaster->toastBagel();
    }
  }
