<?php

declare(strict_types=1);

namespace App\Attributes;

use App\Enums\HttpMethod;
use Attribute;

#[Attribute]
readonly class Post extends Route
{

    public function __construct(string $path)
    {
        parent::__construct(
            $path,
            HttpMethod::POST
        );
    }

}
