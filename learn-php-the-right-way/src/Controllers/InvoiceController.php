<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Get;
use App\EloquentModel\Invoice;
use App\Enums\InvoiceStatus;
use App\View;

class InvoiceController
{

    #[Get('/invoices')]
    public function index(): View
    {
        $invoices = Invoice::query()
            ->where('status', '=', InvoiceStatus::Paid)
            ->get()
            ->toArray();

        return View::make('invoices/index', ['invoices' => $invoices]);
    }

    #[Get('/invoices/create')]
    public function create(): void
    {
        $invoice = new Invoice();

        $invoice->invoice_number = '001';
        $invoice->amount         = 20;
        $invoice->status         = InvoiceStatus::Pending;
        $invoice->save();

        echo 'Created an Invoice: '
            .$invoice->id
            .', '
            .$invoice->due_date->format('Y-m-d H:m:s');
    }

}
