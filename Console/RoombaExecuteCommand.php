<?php
namespace Sigbits\RoombaBundle\Console;

use Sigbits\RoombaBundle\Command\Factory as RoombaCommandFactory;
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
    /**
     * @var RoombaCommandFactory
     */
    private $factory;


    /**
     * RoombaExecuteCommand constructor.
     * @param null|string $name
     * @param RoombaCommandFactory $roombaCommandFactory
     */
    public function __construct($name, RoombaCommandFactory $roombaCommandFactory)
    {
        parent::__construct($name);

        $this->factory = $roombaCommandFactory;
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
        $device = $input->getArgument('device');
        $cmdName = $input->getArgument('cmdName');
        $data = $input->getArgument('data');

        $cmd = $this->factory->create($cmdName, $data);

        $output->writeln(print_r($cmd));
    }
}