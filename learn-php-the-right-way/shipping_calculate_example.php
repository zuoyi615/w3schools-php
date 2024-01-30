<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Services\Shipping\{DimDivisor, PackageDimension, Weight};
use App\Services\Shipping\BillableWeightCalculatorService;

$billableWeightService = new BillableWeightCalculatorService();

$dimension       = new PackageDimension(width: 9, height: 7, length: 15);
$weight          = new Weight(6);
$fedexDimDivisor = 139;

$billableWeight = $billableWeightService->calculate(
    $dimension,
    $weight,
    DimDivisor::FEDEX
);
echo $billableWeight.' lb'.PHP_EOL;

$widerDimension      = $dimension->increaseWidth(10);
$widerBillableWeight = $billableWeightService->calculate(
    $widerDimension,
    $weight,
    DimDivisor::FEDEX
);
echo $widerBillableWeight.' lb'.PHP_EOL;
