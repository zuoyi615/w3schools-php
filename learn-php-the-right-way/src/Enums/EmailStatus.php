<?php

declare(strict_types=1);

namespace App\Enums;

enum EmailStatus: int
{

    case QUEUE  = 0;
    case SENT   = 1;
    case FAILED = 2;

    public function toString(): string
    {
        return match ($this) {
            self::QUEUE => 'In Queue',
            self::SENT => 'Sent',
            self::FAILED => 'Failed',
        };
    }

}
