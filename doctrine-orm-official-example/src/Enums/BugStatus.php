<?php

namespace App\Enums;

enum BugStatus: int
{

    case Reported = 0;
    case Assigned = 1;

    public function toString(): string
    {
        return match ($this) {
            self::Reported => 'Reported',
            self::Assigned => 'Assigned'
        };
    }

}
