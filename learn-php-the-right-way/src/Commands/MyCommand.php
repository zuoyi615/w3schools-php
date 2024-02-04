<?php

declare(strict_types=1);

namespace App\Commands;

use App\Services\InvoiceService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MyCommand extends Command
{

    public function __construct(private readonly InvoiceService $invoiceService)
    {
        parent::__construct('app:my-command');
        $this->setDescription('A custom command in this App');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $messages = 'Paid Invoice: ';
        $messages .= count($this->invoiceService->getPaidInvoices());
        $output->write($messages, true);

        return Command::SUCCESS;
    }

}
