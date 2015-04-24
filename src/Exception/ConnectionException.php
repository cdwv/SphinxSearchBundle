<?php

namespace Ekiwok\SphinxBundle\Exception;

class ConnectionException extends \RuntimeException
{
    /**
     * @param  string $name                 Missing connection name.
     * @param  array  $availableConnections Array of available connections.
     * @return ConnectionException
     */
    public static function missingConnection($name, $availableConnections = array())
    {
        return new self(sprintf("There was no configuration for connection '%s'. Available connections are: [%s]", $name, implode(', ', $availableConnections)));
    }

    /**
     * @param  string $name             Unsupported driver name.
     * @param  array  $availableDrivers Array of available drivers.
     * @return ConnectionException
     */
    public static function unsupportedDriver($name, $availableDrivers = array())
    {
        return new self(sprintf("Driver '%s' is not supportd.. Available drivers are: [%s]", $name, implode(', ', $availableConnections)));
    }
}
