<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../eloquent.php';

use App\EloquentModel\Invoice;
use App\Enums\InvoiceStatus;
use Illuminate\Database\Capsule\Manager as Capsule;

try {
    Capsule::connection()->transaction(function () {
        Invoice
            ::query()
            ->where('status', InvoiceStatus::Paid)
            ->get()
            ->each(function (Invoice $invoice) {
                echo $invoice->id
                    .', '
                    .$invoice->status->toString()
                    .', '
                    .$invoice->created_at->format('Y-m-d H:m:s')
                    .PHP_EOL;

                $item = $invoice->items->first();
                // updated with $invoice->push(), $invoice->save() would not work the same.
                $item->description       = 'Foo Bar1';
                $invoice->invoice_number = '009';
                $invoice->push();
            });
    });
} catch (Throwable $e) {
    var_dump($e);
}
