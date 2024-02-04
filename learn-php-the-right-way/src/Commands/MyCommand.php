<?php

declare(strict_types=1);

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MyCommand extends Command
{

    public function __construct()
    {
        parent::__construct('app:my-command');
        $this->setDescription('A custom command in this App');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $output->write('Hello from custom Command', true);

        return Command::SUCCESS;
    }

}
