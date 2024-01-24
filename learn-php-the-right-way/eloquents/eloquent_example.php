<?php

declare(strict_types=1);

use App\EloquentModel\Invoice;
use App\EloquentModel\InvoiceItem;
use App\Enums\InvoiceStatus;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../eloquent.php';

try {
    Capsule::connection()->transaction(function () {
        $invoice                 = new Invoice();
        $invoice->amount         = 45;
        $invoice->invoice_number = '007';
        $invoice->status         = InvoiceStatus::Pending;
        $invoice->created_at     = new Carbon();
        $invoice->due_date       = (new Carbon())->addDays(10);
        $invoice->save();

        $items = [
            ['Item 01', 1, 15],
            ['Item 02', 2, 7.5],
            ['Item 03', 4, 3.75],
        ];

        foreach ($items as [$description, $quantity, $unitPrice]) {
            $item              = new InvoiceItem();
            $item->description = $description;
            $item->quantity    = $quantity;
            $item->unit_price  = $unitPrice;
            $item->invoice()->associate($invoice);
            $item->save();
        }
    });
} catch (Throwable $e) {
    var_dump($e);
}
