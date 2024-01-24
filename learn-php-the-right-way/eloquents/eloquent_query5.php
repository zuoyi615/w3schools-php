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

                // $invoice->items()->delete(); // delete all the items
                // $invoice->items()->where('id', '>=', 10)->delete();
                $item = $invoice->items->first();
                $item->delete();
            });
    });
} catch (Throwable $e) {
    var_dump($e);
}
