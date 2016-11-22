<?php
namespace Sigbits\RoombaBundle\Device;

use Sigbits\RoombaLib\Device\Roomba;
use Sigbits\RoombaLib\Socket\Connection;


/**
 * Used to be able to configure devices in a database or through the service container (for testing and demo purposes)
 *
 * User: Maarten van Leeuwen <maarten@sigbits.nl>
 * Date: 22/11/2016
 */
class Repository
{
    /**
     * @var array
     */
    private $devices;

    /**
     * Repository constructor.
     */
    public function __construct()
    {
        $this->devices = [];
    }

    /**
     * @param $name
     * @param Roomba $roomba
     */
    public function addDevice($name, $host, $port, $timeout)
    {
        if ($this->has($name)) {
            throw new \UnexpectedValueException(sprintf('Repository already has a device named %s', $name));
        }

        $connection = new Connection($host, $port, $timeout);
        $this->devices[$name] = new Roomba($connection);
    }

    /**
     * @param $name
     * @return bool
     */
    private function has($name)
    {
        return array_key_exists($name, $this->devices);
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function find($name)
    {
        if ($this->has($name)) {
            return $this->devices[$name];
        }

        throw new \Exception(sprintf('Unknown device %s', $name));
    }
}