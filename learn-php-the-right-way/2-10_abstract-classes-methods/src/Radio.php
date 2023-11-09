<?php

  declare(strict_types=1);

  namespace Abstraction;

  class Radio extends Field {

    public function render(): string {
      return <<<Input
<input type="radio" name="$this->name" />
Input;
    }
  }
