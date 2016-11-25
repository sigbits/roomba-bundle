<?php
namespace Sigbits\RoombaBundle\Command;

use Sigbits\RoombaLib\SCI\Command\AbstractCommand as SCICommand;
/**
 * Note: maybe delegate to Sigbits\Roomba\SCI\CommandFactory ?
 *
 * Created by PhpStorm.
 * User: Maarten van Leeuwen <maarten@sigbits.nl>
 * Date: 22/11/2016
 */
class Factory
{
    /**
     * associative array. key = name, value is FQCN of the corresponding SCI command
     *
     * @var array
     */
    private $SCICommands;

    /**
     * Factory constructor.
     * @param array $commands
     */
    public function __construct(array $commands)
    {
        foreach ($commands as $name => $fqcn) {
            $this->addSCICommand($name, $fqcn);
        }
    }

    /**
     * @param $name
     * @param $fqcn
     */
    private function addSCICommand($name, $fqcn)
    {
        $this->assertIsSCICommandClass($fqcn);

        $this->SCICommands[$name] = $fqcn;
    }

    /**
     * @param $fqcn
     * @throws \InvalidArgumentException
     */
    private function assertIsSCICommandClass($fqcn)
    {
        if (!is_subclass_of($fqcn, 'Sigbits\RoombaLib\SCI\Command\AbstractCommand')) {
            throw new \InvalidArgumentException(sprintf('Class %s is not a Sigbits\RoombaLib\SCI\Command', $fqcn));
        }
    }

    /**
     * @param string $name
     */
    public function hasCommand($name)
    {
        return (array_key_exists($name, $this->SCICommands));
    }

    /**
     * @param string $cmdClass
     * @return bool
     */
    private function isDataCommandClass($cmdClass)
    {
        return (is_subclass_of($cmdClass, 'Sigbits\RoombaLib\SCI\Command\AbstractDataCommand'));
    }

    /**
     * @param string $name
     * @param mixed | null $data
     * @return SCICommand
     */
    public function create($name, $data = null)
    {

        if (!$this->hasCommand($name)) {
            throw new \InvalidArgumentException(sprintf('Command Factory has no SCI Command names %s', $name));
        }

        $cmdClass = $this->SCICommands[$name];

        if ($this->isDataCommandClass($cmdClass)) {
            return new $cmdClass($data);
        } else {
            return new $cmdClass();
        }
    }
}