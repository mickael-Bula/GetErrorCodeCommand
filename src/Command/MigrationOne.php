<?php

namespace Migration\Command;

use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationOne extends Command
{
    protected static $defaultName = 'migration:one';
    private Logger $loggerScripts;
    private bool $error = false;

    public function __construct(Logger $loggerScripts)
    {
        $this->loggerScripts = $loggerScripts;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Migration one');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->error) {
            echo "Commande one exécutée\n";
            $this->loggerScripts->info("Appel de la première commande");

            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}