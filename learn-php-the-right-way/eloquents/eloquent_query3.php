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

                // all records selected in memory, and take first
                // There is N+1 problem next line, can be solved by eager loading
                $item = $invoice->items->first();
                // var_dump($item->id);

                // $item = $invoice->items()->first(); // also works, sql select limit 1 record, and take the first

                $item->description = 'Foo Bar';
                $item->save();
            });
    });
} catch (Throwable $e) {
    var_dump($e);
}
