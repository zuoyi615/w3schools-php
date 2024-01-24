<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../eloquent.php';

use App\EloquentModel\Invoice;
use App\Enums\InvoiceStatus;
use Illuminate\Database\Capsule\Manager as Capsule;

try {
    Capsule::connection()->transaction(function () {
        $id = 1;
        Invoice::query()
            ->where('id', '=', $id)
            ->update(['status' => InvoiceStatus::Paid]);

        // $sql = Invoice::query()->where('id', '=', $id)->toSql();
        // var_dump($sql); // select * from `invoices` where `id` = ?
    });
} catch (Throwable $e) {
    var_dump($e);
}
