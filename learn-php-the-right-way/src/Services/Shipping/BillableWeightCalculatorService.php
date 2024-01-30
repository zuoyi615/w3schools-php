<?php

namespace App\Services\Shipping;

class BillableWeightCalculatorService
{

    public function calculate(
        PackageDimension $dimension,
        Weight $weight,
        DimDivisor $dimDivisor
    ): int {
        $width  = $dimension->width;
        $height = $dimension->height;
        $length = $dimension->length;

        $result    = $width * $height * $length / $dimDivisor->value;
        $dimWeight = (int) round($result);

        return max($weight->value, $dimWeight);
    }

}
