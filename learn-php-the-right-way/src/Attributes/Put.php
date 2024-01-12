<?php

    namespace App\Attributes;

    use App\Enums\HttpMethod;

    #[\Attribute]
    readonly class Put extends Route
    {
        public function __construct(string $path)
        {
            parent::__construct(
              $path,
              HttpMethod::PUT
            );
        }
    }
