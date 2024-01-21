<?php

namespace App\Enums;

enum BugStatus: int
{

    case Open   = 0;
    case Closed = 1;

    public function toString(): string
    {
        return match ($this) {
            self::Open => 'open',
            self::Closed => 'close'
        };
    }

}
