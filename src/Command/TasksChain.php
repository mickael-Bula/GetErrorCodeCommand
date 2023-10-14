<?php

namespace Migration\Command;

use Monolog\Logger;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\ExceptionInterface;

class TasksChain extends Command
{
    protected static $defaultName = 'migration:tasks';
    private Logger $loggerScripts;

    public function __construct(Logger $loggerScripts)
    {
        $this->loggerScripts = $loggerScripts;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Lancement des commandes de migration enchaînées');
    }

    /**
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        echo "Commande TasksChain exécutée\n";
        $this->loggerScripts->info("Appel de la commande tasksChain");

        $exitCodes = [];

        if ($this->getApplication() instanceof Application) {
            foreach (self::getCommands() as $commandName) {
                $command = $this->getApplication()->find($commandName);
                $greetInput = new ArrayInput([]);

                $exitCode = $command->run($greetInput, $output);
                $exitCodes[] = $exitCode;

                // vérifie le code retour de la commande exécutée
                if ($exitCode !== Command::SUCCESS) {
                    $this->loggerScripts->error("La commande $commandName a échoué avec le code $exitCode");
                    break;
                }
                // Vérifie si l'un des codes de retour est un échec
                $result = array_filter($exitCodes, static fn ($error) => $error !== Command::SUCCESS);
                if (count($result) > 0) {

                    return Command::FAILURE;
                }
            }
        } else {
            throw new \RuntimeException('Les commandes ne sont pas lancées');
        }

        return Command::SUCCESS;
    }

    public static function getCommands(): array
    {
        return [
            MigrationOne::getDefaultName(),
            MigrationTwo::getDefaultName(),
            MigrationThree::getDefaultName(),
        ];
    }
}