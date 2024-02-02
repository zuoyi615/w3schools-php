<?php

namespace App\DTO;

class SimpleCollection
{

    public function __construct(
        public int $id,
        public string $name,
        public string $originalName,
        public string $originalLanguage,
        public string $overview,
        public ?bool $adult,
        public ?string $backdropPath,
        public ?string $posterPath,
    ) {}

}
