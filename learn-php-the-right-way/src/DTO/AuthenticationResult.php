<?php

namespace App\DTO;

class AuthenticationResult
{

    public function __construct(
        public int $success,
        public int $statusCode,
        public string $statusMessage
    ) {}

}
