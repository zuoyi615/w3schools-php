<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Models\Invoice;
use App\Enums\InvoiceStatus;
use Twig\Environment as Twig;

readonly class InvoiceController
{

    public function __construct(private Twig $twig) {}

    #[Get('/invoices')]
    public function index(): string
    {
        $invoices = Invoice::query()
            ->where('status', '=', InvoiceStatus::Paid)
            ->get()
            ->map(fn(Invoice $invoice) => [
                'invoiceNumber' => $invoice->invoice_number,
                'amount'        => $invoice->amount,
                'status'        => $invoice->status->toString(),
                'dueDate'       => $invoice->due_date->toDateTimeString(),
            ]);

        return $this
            ->twig
            ->render('invoices/index.twig', ['invoices' => $invoices]);
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
