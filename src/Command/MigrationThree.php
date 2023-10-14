<?php

namespace Migration\Command;

use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationThree extends Command
{
    protected static $defaultName = 'migration:three';
    private Logger $loggerScripts;
    private bool $error = false;

    public function __construct(Logger $loggerScripts)
    {
        $this->loggerScripts = $loggerScripts;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Migration three');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->error) {
            echo "Commande three exécutée\n";
            $this->loggerScripts->info("Appel de la troisième commande");

            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}