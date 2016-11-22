<?php
namespace Sigbits\RoombaLib\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by PhpStorm.
 * User: Maarten van Leeuwen <maarten@sigbits.nl>
 * Date: 22/11/2016
 */
class RoombaExecuteCommand extends Command
{
    public function __construct($name, array $commands)
    {
        parent::__construct($name);
    }

    public function configure()
    {
        $this->setDescription('Send a command to a configured Roomba')
            ->addArgument('device', InputArgument::REQUIRED, 'The identifier of a configured Roomba device')
            ->addArgument('cmdName', InputArgument::REQUIRED, 'The name of the command to be executed')
            ->addArgument('data', InputArgument::OPTIONAL, 'Optional data (only for datacommands)');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // @todo implement
    }
}