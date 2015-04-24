<?php

namespace Ekiwok\SphinxBundle\Exception;

class ConnectionException extends \RuntimeException
{
    /**
     * @param  string $name                 Missing connection name.
     * @param  array  $availableConnections Array of available connections.
     * @return ConnectionException
     */
    public function missingConnection($name, $availableConnections = array())
    {
        return new self(sprintf("There was no configuration for connection '%s'. Available connections are: []", $name, implode(', ', $availableConnections)));
    }

    /**
     * @param  string $name             Unsupported driver name.
     * @param  array  $availableDrivers Array of available drivers.
     * @return ConnectionException
     */
    public function unsupportedDriver($name, $availableDrivers = array())
    {
        return new self(sprintf("Driver '%s' is not supportd.. Available drivers are: []", $name, implode(', ', $availableConnections)));
    }
}
