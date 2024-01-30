<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Services\Shipping\BillableWeightCalculatorService;

$package = [
    'weight'     => 6,
    'dimensions' => [
        'width'  => 9,
        'length' => 15,
        'height' => 7,
    ],
];

$fedexDimDivisor = 139;

$billableWeight = (new BillableWeightCalculatorService())->calculate(
    $package['dimensions']['width'],
    $package['dimensions']['height'],
    $package['dimensions']['length'],
    $package['weight'],
    $fedexDimDivisor
);

echo $billableWeight.' lb'.PHP_EOL;
