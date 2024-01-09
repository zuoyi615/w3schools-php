<?php

  declare(strict_types=1);

  namespace SendEmail\Enums;

  enum Color: string {
    case Green  = 'green';
    case Red    = 'red';
    case Gray   = 'gray';
    case Orange = 'orange';

    public function getClass(): string {
      return 'color-'.$this->value;
    }
  }
