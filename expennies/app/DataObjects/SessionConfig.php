<?php

namespace App\DataObjects;

use App\Enum\SameSite;

readonly class SessionConfig
{

    public function __construct(
        public string $name,
        public bool $secure,
        public bool $httpOnly,
        public SameSite $sameSite
    ) {}

}