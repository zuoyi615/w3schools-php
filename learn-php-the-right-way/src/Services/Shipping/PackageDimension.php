<?php

namespace App\Services\Shipping;

use InvalidArgumentException;

readonly class PackageDimension
{

    public function __construct(
        public int $width,
        public int $height,
        public int $length,
    ) {
        match (true) {
            $width <= 0 || $width >= 80 => $this->throwException('width'),
            $height <= 0 || $height >= 70 => $this->throwException('height'),
            $length <= 0 || $length >= 120 => $this->throwException('length'),
            default => true
        };
    }

    private function throwException(string $name): InvalidArgumentException
    {
        throw new InvalidArgumentException("Invalid Dimension: $name");
    }

    public function increaseWidth(int $amount): self
    {
        return new self($this->width + $amount, $this->height, $this->length);
    }

    public function equalsTo(PackageDimension $other): bool
    {
        return $this->width === $other->width
            && $this->height === $other->height
            && $this->length === $other->length;
    }

}
