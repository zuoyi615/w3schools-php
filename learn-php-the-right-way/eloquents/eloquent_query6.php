<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../eloquent.php';

use App\Enums\InvoiceStatus;
use Illuminate\Database\Capsule\Manager as Capsule;

try {
    Capsule::connection()->transaction(function () {
        $invoices = Capsule::connection()
            ->query()
            ->from('invoices')
            ->where('id', '=', 1)
            ->get();
        var_dump($invoices); // std class objects, which is from Base Query Builder, another is Eloquent Query Builder
        
        $invoices = Capsule::connection()
            ->table('invoices')
            ->where('status', '=', InvoiceStatus::Paid)
            ->get();
        // std class objects, which is from Base Query Builder, another is Eloquent Builder which has Query Builder as dependency
        // same goes with Collections, Laravel has to Collections, one works with the eloquent, another one is base Collection
        var_dump($invoices);
    });
} catch (Throwable $e) {
    var_dump($e->getMessage());
}
