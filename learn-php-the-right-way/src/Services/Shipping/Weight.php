<?php

declare(strict_types=1);

namespace App\Services\Shipping;

use InvalidArgumentException;

readonly class Weight
{

    public function __construct(public int $value)
    {
        if ($this->value <= 0 || $this->value >= 150) {
            throw  new InvalidArgumentException('Invalid package weight');
        }
    }

    private function throwException(string $name): InvalidArgumentException
    {
        throw new InvalidArgumentException("Invalid Dimension: $name");
    }

    public function equalsTo(Weight $other): bool
    {
        return $this->value === $other->value;
    }

}
