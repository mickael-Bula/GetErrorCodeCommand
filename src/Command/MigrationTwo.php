<?php

namespace Migration\Command;

use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationTwo extends Command
{
    protected static $defaultName = 'migration:two';
    private Logger $loggerScripts;
    private bool $error = true;

    public function __construct(Logger $loggerScripts)
    {
        $this->loggerScripts = $loggerScripts;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Migration two');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->error) {
            echo "Commande two exécutée\n";
            $this->loggerScripts->info("Appel de la deuxième commande");

            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}