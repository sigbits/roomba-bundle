<?php
namespace Sigbits\RoombaBundle\Console;

use Sigbits\RoombaBundle\Device\Repository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by PhpStorm.
 * User: Maarten van Leeuwen <maarten@sigbits.nl>
 * Date: 22/11/2016
 */
class RoombaCallCommand extends Command
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var array
     */
    private $aliases;

    /**
     * RoombaCommandCommand constructor.
     * @param null|string $name
     */
    public function __construct($name, array $aliases = [], Repository $repository)
    {
        $this->aliases = $aliases;
        $this->repository = $repository;

        parent::__construct($name);
    }

    public function configure()
    {
        $this->setDescription('Send a command to a configured Roomba')
            ->setAliases($this->aliases)
            ->addArgument('device', InputArgument::REQUIRED, 'The identifier of a configured Roomba device')
            ->addArgument('cmdName', InputArgument::REQUIRED, 'The name of the command to be executed')
            ->addArgument('data', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'Optional data (only for datacommands)');
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

        $roomba = $this->repository->find($device);

        call_user_func_array([$roomba, $cmdName], [$data]);
    }
}